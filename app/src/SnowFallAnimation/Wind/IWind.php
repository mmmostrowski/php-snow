<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation\Wind;


use TechBit\Snow\SnowFallAnimation\Object\IAnimationAliveObject;

interface IWind extends IAnimationAliveObject
{

    public function moveParticle(int $idx): void;

}