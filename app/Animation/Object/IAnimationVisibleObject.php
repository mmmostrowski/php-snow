<?php

namespace TechBit\Snow\Animation\Object;


interface IAnimationVisibleObject extends IAnimationObject
{
    public function renderFirstFrame();

    public function renderLoopFrame();

}