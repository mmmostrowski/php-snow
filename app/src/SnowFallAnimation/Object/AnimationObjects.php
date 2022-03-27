<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation\Object;

use InvalidArgumentException;

final class AnimationObjects
{

    /**
     * @var IAnimationObject[]
     */
    private readonly array $objects;

    /**
     * @var IAnimationVisibleObject[]
     */
    private readonly array $visibleObjects;

    /**
     * @var IAnimationAliveObject[]
     */
    private readonly array $aliveObjects;


    /**
     * @param IAnimationObject[] $objects
     */
    public function __construct(array $objects)
    {
        $aliveObjects = [];
        $visibleObjects = [];

        foreach ($objects as $object) {
            $class = get_class($object);

            if (!$object instanceof IAnimationObject) {
                throw new InvalidArgumentException("Expected object of type: " . IAnimationObject::class . ". Got: " . $class);
            }

            if ($object instanceof IAnimationAliveObject) {
                $aliveObjects[$class] = $object;
            }
            if ($object instanceof IAnimationVisibleObject) {
                $visibleObjects[$class] = $object;
            }
        }

        $this->objects = $objects;
        $this->aliveObjects = $aliveObjects;
        $this->visibleObjects = $visibleObjects;
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