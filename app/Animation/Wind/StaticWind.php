<?php namespace TechBit\Snow\Animation\Wind;

use TechBit\Snow\Animation\Object\IAnimationAliveObject;
use TechBit\Snow\Animation\Snow\ParticlesSet;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Math\PerlinNoise1D;


class StaticWind implements IAnimationAliveObject, IWind
{
    /**
     * @var float
     */
    protected $directionX = 0.0;

    /**
     * @var float
     */
    protected $directionY = 0.0;

    /**
     * @var float
     */
    protected $strengthMax = 0.0;

    /**
     * @var float
     */
    protected $strengthMin = 0.0;

    /**
     * @var float
     */
    protected $time = 0.0;
    /**
     * @var float
     */
    protected $windVariation = 1.0;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var PerlinNoise1D
     */
    protected $windStrengthNoise;
    /**
     * @var PerlinNoise1D
     */
    protected $windDirectionNoise;
    /**
     * @var ParticlesSet
     */
    protected $particles;

    public function __construct(PerlinNoise1D $windStrengthNoise, PerlinNoise1D $windDirectionNoise, Config $config, ParticlesSet $particles)
    {
        $this->windStrengthNoise = $windStrengthNoise;
        $this->windDirectionNoise = $windDirectionNoise;
        $this->config = $config;
        $this->particles = $particles;
    }

    public function initialize()
    {
        $this->strengthMin = $this->config->windGlobalStrengthMin();
        $this->strengthMax = $this->config->windGlobalStrengthMax();
        $this->windVariation = $this->config->windGlobalVariation();
        $this->generateNewWindDirection();
    }

    public function update()
    {
        $this->time += 0.01 * $this->windVariation;
        $this->generateNewWindDirection();
    }

    public function moveParticle($idx)
    {
        $this->particles->moveBy($idx, $this->directionX, $this->directionY);
    }

    protected function generateNewWindDirection()
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