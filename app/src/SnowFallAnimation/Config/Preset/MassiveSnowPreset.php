<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation\Config\Preset;

use TechBit\Snow\SnowFallAnimation\Config\Config;


final class MassiveSnowPreset extends Config
{

    public function snowProducingTempo(): int
    {
        return parent::snowProducingTempo() * 26;
    }

}