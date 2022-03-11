<?php

namespace TechBit\Snow\Config;

use TechBit\Snow\Config\Preset\CalmPreset;
use TechBit\Snow\Config\Preset\ClassicalPreset;
use TechBit\Snow\Config\Preset\MassiveSnowPreset;
use TechBit\Snow\Config\Preset\SnowyPreset;
use TechBit\Snow\Config\Preset\WindyPreset;


class DefaultPresets
{

    public function presets()
    {
        return [
            ClassicalPreset::class => 90,
            WindyPreset::class => 20,
            SnowyPreset::class => 20,
            MassiveSnowPreset::class => 10,
        ];
    }

}