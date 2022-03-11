<?php namespace TechBit\Snow\Config\Preset;

use TechBit\Snow\Config\Config;


class NoSnowPreset extends Config
{

    public function snowMaxNumOfFlakesAtOnce()
    {
        return 0;
    }
}