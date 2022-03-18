<?php declare(strict_types=1);

namespace TechBit\Snow\Animation\Wind;

use TechBit\Snow\Animation\Object\IAnimationAliveObject;
use TechBit\Snow\Animation\Snow\ParticlesSet;
use TechBit\Snow\Config\Config;


class MicroWavingWind implements IAnimationAliveObject, IWind
{

    protected float $microMovementConstant = 0.0;

    protected float $microMovementFrequency = 0.0;

    protected float $microMovementTime = 0.0;


    public function __construct(
        protected readonly ParticlesSet $particles,
        protected readonly Config $config )
    {
    }

    public function initialize(): void
    {
        $this->microMovementConstant = $this->config->microMovementPower();
        $this->microMovementFrequency = $this->config->microMovementFrequency();
    }

    public function update(): void
    {
        $this->microMovementTime += 0.5;
    }

    public function moveParticle(int $idx): void
    {
        if ($this->microMovementFrequency) {
            $offset = $idx;
            $microMovement = sin($this->microMovementTime * $this->microMovementFrequency + $offset) * $this->microMovementConstant;
        } else {
            $microMovement = 0;
        }

        $this->particles->moveByX($idx, $microMovement);
    }

}