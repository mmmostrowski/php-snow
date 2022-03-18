<?php declare(strict_types=1);

namespace TechBit\Snow\Animation\Wind;

use TechBit\Snow\Animation\Object\IAnimationAliveObject;
use TechBit\Snow\Animation\Snow\ParticlesSet;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Console\Console;


class BlowWind implements IAnimationAliveObject, IWind
{
    const TIME = 0;
    const X = 1;
    const Y = 2;
    const ANIMATION_LENGTH = 3;
    const RADIUS = 4;
    const RADIUS_SQUARE = 5;
    const CORE_RADIUS = 6;
    const STRENGTH = 7;

    protected float $time = 0.0;

    protected array $blowSources = [];

    protected int $maxNumOfWindBlows = 0;

    protected int $frequencyOfWindBlows = 0;

    protected float $minStrength = 0.0;

    protected float $maxStrength = 0.0;

    protected int $minAnimationLength = 0;

    protected int $maxAnimationLength = 0;


    public function __construct(
        protected readonly Config $config,
        protected readonly ParticlesSet $particles,
        protected readonly Console $console)
    {
    }

    public function initialize(): void
    {
        $this->time = 0.0;
        $this->frequencyOfWindBlows = $this->config->windBlowsFrequency();
        $this->maxNumOfWindBlows = $this->config->windBlowsMaxNumAtSameTime();
        $this->minStrength = $this->config->windBlowsMinStrength();
        $this->maxStrength = $this->config->windBlowsMaxStrength();
        $this->minAnimationLength = $this->config->windBlowsMinAnimationLength();
        $this->maxAnimationLength = $this->config->windBlowsMaxAnimationLength();
    }

    public function update(): void
    {
        $this->time += 1.0;

        if (count($this->blowSources) >= $this->maxNumOfWindBlows) {
            return;
        }

        if (rand(0, 20) == 0 && rand(0, 100) < $this->frequencyOfWindBlows) {
            $this->generateNewWindBlow();
        }
    }

    public function moveParticle(int $idx): void
    {
        $x = $this->particles->x($idx);
        $y = $this->particles->y($idx);

        foreach ($this->blowSources as $blowId => $blowSource) {
            $this->blowFromSource($blowId, $idx, $x, $y, $blowSource);
        }
    }

    protected function blowFromSource(int $blowId, int $particleIdx, float $x, float $y, array $blowSource): void
    {
        $vx = (float)($x - $blowSource[self::X]);
        $vy = (float)($y - $blowSource[self::Y]);

        $distSquare = $vx * $vx + $vy * $vy;

        if (abs($distSquare) < 0.00001 || $blowSource[self::RADIUS_SQUARE] < $distSquare) {
            return;
        }

        $dist = sqrt($distSquare);
        $deltaTime = ($this->time - $blowSource[self::TIME]) / $blowSource[self::ANIMATION_LENGTH];
        if ($deltaTime > 1) {
            $this->removeSource($blowId);
            return;
        }

        $power = $blowSource[self::RADIUS] - $dist;
        if ($power > $blowSource[self::CORE_RADIUS]) {
            $power = $blowSource[self::CORE_RADIUS];
        }

        $animationFactor = 0.5 + cos($deltaTime * M_PI) / 2;
        $ratio = (1.0 / $dist) * $blowSource[self::STRENGTH] * $power * $animationFactor * 0.001;

        $this->particles->updateMomentum(
            $particleIdx,
            $vx * $ratio,
            $vy * $ratio
        );
    }

    protected function generateNewWindBlow(): void
    {
        $minAfterEdge = 2;
        $maxAfterEdge = 10;
        $strength = rand((int)($this->minStrength * 10000), (int)($this->maxStrength * 10000)) / 10000;
        $coreRadiusRatio = (float)(rand(70, 100) / 100);
        $animationLength = (int)(rand((int)($this->minAnimationLength * 10000), (int)($this->maxAnimationLength * 10000)) / 10000);

        $left = rand(1, 2) == 1;
        $y = rand((int)$this->console->minY(), (int)$this->console->maxY());
        if ($left) {
            $x = rand((int)$this->console->minX() - $minAfterEdge, (int)$this->console->minX() - $maxAfterEdge);
        } else {
            $x = rand((int)$this->console->maxX() + $minAfterEdge, (int)$this->console->maxX() + $maxAfterEdge);
        }

        $radius = $this->console->width() + $maxAfterEdge * 2.0 + 10.0;
        $this->addBlowSource($x, $y, $strength, $radius, $radius * $coreRadiusRatio, $animationLength);
    }

    protected function addBlowSource(float $x, float $y, float $strength, float $radius, float $coreRadius, int $animationLength): void
    {
        $this->blowSources[] = [
            self::X => $x,
            self::Y => $y,
            self::STRENGTH => $strength,
            self::RADIUS => $radius,
            self::RADIUS_SQUARE => $radius * $radius,
            self::CORE_RADIUS => $coreRadius,
            self::ANIMATION_LENGTH => $animationLength,
            self::TIME => $this->time,
        ];
    }

    protected function removeSource(int $blowId): void
    {
        unset($this->blowSources[$blowId]);
    }

}