<?php

namespace TechBit\Snow\Animation\Wind;

use TechBit\Snow\Animation\Object\IAnimationAliveObject;
use TechBit\Snow\Animation\Snow\ParticlesSet;
use TechBit\Snow\Config\Config;


class MicroWavingWind implements IAnimationAliveObject, IWind
{
    /**
     * @var float
     */
    protected $microMovementConstant = 0.0;

    /**
     * @var
     */
    protected $microMovementFrequency = 0.0;

    /**
     * @var float
     */
    protected $microMovementTime = 0.0;

    /**
     * @var ParticlesSet
     */
    protected $particles;

    /**
     * @var Config
     */
    protected $config;

    public function __construct(ParticlesSet $particles, Config $config)
    {
        $this->particles = $particles;
        $this->config = $config;
    }

    public function initialize()
    {
        $this->microMovementConstant = $this->config->microMovementPower();
        $this->microMovementFrequency = $this->config->microMovementFrequency();
    }

    public function update()
    {
        $this->microMovementTime += 0.5;
    }

    public function moveParticle($idx)
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