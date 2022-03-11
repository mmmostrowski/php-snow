<?php namespace TechBit\Snow\Config\Preset;

use TechBit\Snow\Config\Config;


class NoGravityPreset extends Config
{

    public function gravity()
    {
        return 0;
    }
}