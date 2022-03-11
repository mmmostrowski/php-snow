<?php

namespace TechBit\Snow\Animation\Wind;

use TechBit\Snow\Animation\Object\IAnimationObject;
use TechBit\Snow\Config\Config;


class WindComposition implements IWind, IAnimationObject
{

    /**
     * @var IWind[]
     */
    protected $windForces;

    /**
     * @var \Psr\Container\ContainerInterface
     */
    protected $objectManager;

    /**
     * @var Config
     */
    protected $config;

    public function __construct(\Psr\Container\ContainerInterface $objectManager, Config $config)
    {
        $this->objectManager = $objectManager;
        $this->config = $config;
    }

    public function initialize()
    {
        foreach ($this->config->windForces() as $windClass) {
            $this->windForces[$windClass] = $this->objectManager->get($windClass);
        }
    }

    public function moveParticle($idx)
    {
        foreach ($this->windForces as $wind) {
            $wind->moveParticle($idx);
        }
    }
}