<?php declare(strict_types=1);

namespace TechBit\Snow\Animation\Object;


interface IAnimationVisibleObject extends IAnimationObject
{

    public function renderFirstFrame(): void;

    public function renderLoopFrame(): void;

}