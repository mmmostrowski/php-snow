<?php declare(strict_types=1);

namespace TechBit\Snow\Animation\Wind;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use TechBit\Snow\Animation\Object\IAnimationObject;
use TechBit\Snow\Config\Config;


class WindComposition implements IWind, IAnimationObject
{

    /**
     * @var IWind[]
     */
    protected array $windForces = [];

    public function __construct(
        protected readonly ContainerInterface $objectManager,
        protected readonly Config $config)
    {
    }

    /**
     * @throws ContainerExceptionInterface
     */
    public function initialize(): void
    {
        foreach ($this->config->windForces() as $windClass) {
            $this->windForces[$windClass] = $this->objectManager->get($windClass);
        }
    }

    public function moveParticle(int $idx): void
    {
        foreach ($this->windForces as $wind) {
            $wind->moveParticle($idx);
        }
    }
}