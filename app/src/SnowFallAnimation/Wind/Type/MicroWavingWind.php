<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation\Wind\Type;

use TechBit\Snow\SnowFallAnimation\AnimationContext;
use TechBit\Snow\SnowFallAnimation\Snow\SnowParticles;
use TechBit\Snow\SnowFallAnimation\Wind\IWind;


final class MicroWavingWind implements IWind
{

    private readonly SnowParticles $particles;

    private readonly float $microMovementConstant;

    private readonly float $microMovementFrequency;

    private float $microMovementTime = 0.0;


    public function initialize(AnimationContext $context): void
    {
        $this->particles = $context->snowParticles();
        $this->microMovementConstant = $context->config()->microMovementPower();
        $this->microMovementFrequency = $context->config()->microMovementFrequency();
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