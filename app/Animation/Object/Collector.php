<?php declare(strict_types=1);

namespace TechBit\Snow\Animation\Object;

use Psr\Container\ContainerExceptionInterface;
use TechBit\Snow\Animation\AnimationObjectsList;
use Psr\Container\ContainerInterface;

class Collector
{

    protected array $objects = [];

    protected array $visibleObjects = [];

    protected array $aliveObjects = [];


    public function __construct(
        protected readonly ContainerInterface $di)
    {
    }

    /**
     * @throws ContainerExceptionInterface
     */
    public function collect(AnimationObjectsList $all): void
    {
        foreach ($all->allElements() as $class) {
            $object = $this->di->get($class);
            if ($object instanceof IAnimationObject) {
                $this->objects[$class] = $object;
            }
            if ($object instanceof IAnimationAliveObject) {
                $this->aliveObjects[$class] = $object;
            }
            if ($object instanceof IAnimationVisibleObject) {
                $this->visibleObjects[$class] = $object;
            }
        }
    }

    /**
     * @return IAnimationObject[]
     */
    public function allObjects(): array
    {
        return $this->objects;
    }

    /**
     * @return IAnimationVisibleObject[]
     */
    public function allVisibleObjects(): array
    {
        return $this->visibleObjects;
    }

    /**
     * @return IAnimationAliveObject[]
     */
    public function allAliveObjects(): array
    {
        return $this->aliveObjects;
    }

}