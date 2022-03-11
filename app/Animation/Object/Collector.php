<?php

namespace TechBit\Snow\Animation\Object;

use TechBit\Snow\Animation\AnimationObjectsList;
use Psr\Container\ContainerInterface;
use Zend\Di\Di;

class Collector
{

    /**
     * @var ContainerInterface
     */
    protected $di;

    /**
     * @var IAnimationObject[]
     */
    protected $objects = [];

    /**
     * @var IAnimationVisibleObject[]
     */
    protected $visibleObjects = [];

    /**
     * @var IAnimationAliveObject[]
     */
    protected $aliveObjects = [];

    public function __construct(ContainerInterface $di)
    {
        $this->di = $di;
    }

    public function collect(AnimationObjectsList $all)
    {
        foreach (array_unique($all->allElements()) as $class) {
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
    public function allObjects()
    {
        return $this->objects;
    }

    /**
     * @return IAnimationVisibleObject[]
     */
    public function allVisibleObjects()
    {
        return $this->visibleObjects;
    }

    /**
     * @return IAnimationAliveObject[]
     */
    public function allAliveObjects()
    {
        return $this->aliveObjects;
    }


}