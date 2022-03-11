<?php namespace TechBit\Snow\Config\Preset;

use TechBit\Snow\Config\Config;


class MassiveSnowPreset extends Config
{

    public function snowProducingTempo()
    {
        return parent::snowProducingTempo() * 26;
    }

}