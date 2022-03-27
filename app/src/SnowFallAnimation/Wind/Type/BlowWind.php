<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation\Wind\Type;

use TechBit\Snow\SnowFallAnimation\AnimationContext;
use TechBit\Snow\SnowFallAnimation\Snow\SnowParticles;
use TechBit\Snow\SnowFallAnimation\Wind\IWind;
use TechBit\Snow\Console\IConsole;


final class BlowWind implements IWind
{
    const TIME = 0;
    const X = 1;
    const Y = 2;
    const ANIMATION_LENGTH = 3;
    const RADIUS = 4;
    const RADIUS_SQUARE = 5;
    const CORE_RADIUS = 6;
    const STRENGTH = 7;

    private readonly SnowParticles $particles;

    private readonly IConsole $console;

    private readonly int $maxNumOfWindBlows;

    private readonly int $frequencyOfWindBlows;

    private readonly float $minStrength;

    private readonly float $maxStrength;

    private readonly int $minAnimationLength;

    private readonly int $maxAnimationLength;

    private float $time = 0.0;

    private array $blowSources = [];


    public function initialize(AnimationContext $context): void
    {
        $this->particles = $context->snowParticles();
        $this->console = $context->console();

        $this->time = 0.0;
        $this->frequencyOfWindBlows = $context->config()->windBlowsFrequency();
        $this->maxNumOfWindBlows = $context->config()->windBlowsMaxNumAtSameTime();
        $this->minStrength = $context->config()->windBlowsMinStrength();
        $this->maxStrength = $context->config()->windBlowsMaxStrength();
        $this->minAnimationLength = $context->config()->windBlowsMinAnimationLength();
        $this->maxAnimationLength = $context->config()->windBlowsMaxAnimationLength();
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

    private function generateNewWindBlow(): void
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

    private function addBlowSource(float $x, float $y, float $strength, float $radius, float $coreRadius, int $animationLength): void
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

    public function moveParticle(int $idx): void
    {
        $x = $this->particles->x($idx);
        $y = $this->particles->y($idx);

        foreach ($this->blowSources as $blowId => $blowSource) {
            $this->blowFromSource($blowId, $idx, $x, $y, $blowSource);
        }
    }

    private function blowFromSource(int $blowId, int $particleIdx, float $x, float $y, array $blowSource): void
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

    private function removeSource(int $blowId): void
    {
        unset($this->blowSources[$blowId]);
    }

}