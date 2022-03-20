<?php declare(strict_types=1);

namespace TechBit\Snow\Config\Preset;

use TechBit\Snow\Config\Config;


class NoGravityPreset extends Config
{

    public function gravity(): float
    {
        return 0.0;
    }

}