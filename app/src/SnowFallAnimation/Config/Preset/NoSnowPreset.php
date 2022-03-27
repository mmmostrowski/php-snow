<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation\Config\Preset;

use TechBit\Snow\SnowFallAnimation\Config\Config;


final class NoSnowPreset extends Config
{

    public function hasWind(): bool
    {
        return false;
    }

    public function snowMaxNumOfFlakesAtOnce(): int
    {
        return 0;
    }

}