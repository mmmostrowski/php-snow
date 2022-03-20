<?php declare(strict_types=1);

namespace TechBit\Snow\Animation\Object;


interface IAnimationAliveObject extends IAnimationObject
{

    public function update(): void;

}