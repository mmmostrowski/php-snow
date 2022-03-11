<?php


namespace TechBit\Snow\Config\Preset;

use TechBit\Snow\Config\Config;

class TestPerformancePreset extends Config
{

    public function fps()
    {
        return 10000;
    }

    public function snowProducingTempo()
    {
        return parent::snowProducingTempo() * 100;
    }

    public function showFps()
    {
        return true;
    }

}