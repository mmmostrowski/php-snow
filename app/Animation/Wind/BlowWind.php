<?php

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

    /**
     * @var float
     */
    protected $time = 0.0;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var ParticlesSet
     */
    protected $particles;

    /**
     * @var Console
     */
    protected $console;

    /**
     * @var array[]
     */
    protected $blowSources = [];

    /**
     * @var int
     */
    protected $maxNumOfWindBlows = 0;
    /**
     * @var int
     */
    protected $frequencyOfWindBlows = 0;
    /**
     * @var float
     */
    protected $minStrength = 0.0;

    /**
     * @var float
     */
    protected $maxStrength = 0.0;

    /**
     * @var int
     */
    protected $minAnimationLength = 0;
    /**
     * @var int
     */
    protected $maxAnimationLength = 0;


    public function __construct(Config $config, ParticlesSet $particles, Console $console)
    {
        $this->config = $config;
        $this->particles = $particles;
        $this->console = $console;
    }

    public function initialize()
    {
        $this->time = 0.0;
        $this->frequencyOfWindBlows = $this->config->windBlowsFrequency();
        $this->maxNumOfWindBlows = $this->config->windBlowsMaxNumAtSameTime();
        $this->minStrength = $this->config->windBlowsMinStrength();
        $this->maxStrength = $this->config->windBlowsMaxStrength();
        $this->minAnimationLength = $this->config->windBlowsMinAnimationLength();
        $this->maxAnimationLength = $this->config->windBlowsMaxAnimationLength();
    }

    public function update()
    {
        $this->time += 1.0;

        if (count($this->blowSources) >= $this->maxNumOfWindBlows) {
            return;
        }

        if (rand(0, 20) == 0 && rand(0, 100) < $this->frequencyOfWindBlows) {
            $this->generateNewWindBlow();
        }
    }

    public function moveParticle($idx)
    {
        $x = $this->particles->x($idx);
        $y = $this->particles->y($idx);

        foreach ($this->blowSources as $blowId => $blowSource) {
            $this->blowFromSource($blowId, $idx, $x, $y, $blowSource);
        }
    }

    protected function blowFromSource($blowId, $particleIdx, $x, $y, $blowSource)
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

    protected function addBlowSource($x, $y, $strength, $radius, $coreRadius, $animationLength)
    {
        $this->blowSources[] = [
            self::X => (float)$x,
            self::Y => (float)$y,
            self::STRENGTH => (float)$strength,
            self::RADIUS => (float)$radius,
            self::RADIUS_SQUARE => (float)$radius * $radius,
            self::CORE_RADIUS => (float)$coreRadius,
            self::ANIMATION_LENGTH => (int)$animationLength,
            self::TIME => (float)$this->time,
        ];
    }

    protected function generateNewWindBlow()
    {
        $minAfterEdge = 2;
        $maxAfterEdge = 10;
        $strength = rand((int)($this->minStrength * 10000), (int)($this->maxStrength * 10000)) / 10000;
        $coreRadiusRatio = (float)(rand(70, 100) / 100);
        $animationLength = rand((int)($this->minAnimationLength * 10000), (int)($this->maxAnimationLength * 10000)) / 10000;

        $left = rand(1, 2) == 1;
        $y = rand($this->console->minY(), $this->console->maxY());
        if ($left) {
            $x = rand($this->console->minX() - $minAfterEdge, $this->console->minX() - $maxAfterEdge);
        } else {
            $x = rand($this->console->maxX() + $minAfterEdge, $this->console->maxX() + $maxAfterEdge);
        }

        $radius = $this->console->width() + $maxAfterEdge * 2 + 10;
        $this->addBlowSource($x, $y, $strength, $radius, $radius * $coreRadiusRatio, $animationLength);
    }

    protected function removeSource($blowId)
    {
        unset($this->blowSources[$blowId]);
    }

}