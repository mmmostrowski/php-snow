<?php declare(strict_types=1);

namespace TechBit\Snow\Config\Preset;

use TechBit\Snow\Config\Config;


class MassiveSnowPreset extends Config
{

    public function snowProducingTempo(): int
    {
        return parent::snowProducingTempo() * 26;
    }

}