<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation\Scene;

use TechBit\Snow\SnowFallAnimation\Object\IAnimationObject;

final class SceneFactory implements ISceneFactory
{

    public function create(?string $customSceneTxt): IAnimationObject
    {
        return $customSceneTxt === null
            ? new Scene()
            : new CustomScene($customSceneTxt);
    }

}