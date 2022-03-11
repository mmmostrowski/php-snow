<?php namespace TechBit\Snow\Config\Preset;

use TechBit\Snow\Config\Config;


class NoWindPreset extends Config
{

    public function windFieldStrengthMax()
    {
        return 0;
    }

    public function windGlobalStrengthMin()
    {
        return 0;
    }

    public function windGlobalStrengthMax()
    {
        return 0;
    }
}