<?php declare(strict_types=1);

namespace TechBit\Snow\Animation\Wind;

use TechBit\Snow\Animation\Object\IAnimationAliveObject;
use TechBit\Snow\Animation\Snow\ParticlesSet;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Math\PerlinNoise1D;


class StaticWind implements IAnimationAliveObject, IWind
{

    protected float $time = 0.0;

    protected float $directionX = 0.0;

    protected float $directionY = 0.0;

    protected float $strengthMax = 0.0;

    protected float $strengthMin = 0.0;

    protected float $windVariation = 1.0;


    public function __construct(
        protected readonly PerlinNoise1D $windStrengthNoise,
        protected readonly PerlinNoise1D $windDirectionNoise,
        protected readonly Config $config,
        protected readonly ParticlesSet $particles )
    {
    }

    public function initialize(): void
    {
        $this->strengthMin = $this->config->windGlobalStrengthMin();
        $this->strengthMax = $this->config->windGlobalStrengthMax();
        $this->windVariation = $this->config->windGlobalVariation();
        $this->generateNewWindDirection();
    }

    public function update(): void
    {
        $this->time += 0.01 * $this->windVariation;
        $this->generateNewWindDirection();
    }

    public function moveParticle(int $idx): void
    {
        $this->particles->moveBy($idx, $this->directionX, $this->directionY);
    }

    protected function generateNewWindDirection(): void
    {
        $direction = $this->windStrengthNoise->generateInRange($this->time / 10,
            -(M_PI / 2),
            +(M_PI / 2)
        );

        $strength = $this->windDirectionNoise->generateInRange($this->time,
            $this->strengthMin * abs($direction),
            $this->strengthMax * abs($direction)
        );

        $this->directionX = -sin($direction) * $strength;
        $this->directionY = (cos($direction) * $strength) / 30;
    }

}