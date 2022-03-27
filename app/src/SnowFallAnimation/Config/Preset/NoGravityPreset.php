<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation\Config\Preset;

use TechBit\Snow\SnowFallAnimation\Config\Config;


final class NoGravityPreset extends Config
{

    public function gravity(): float
    {
        return 0.0;
    }

}