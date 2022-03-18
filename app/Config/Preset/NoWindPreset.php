<?php declare(strict_types=1);

namespace TechBit\Snow\Config\Preset;

use TechBit\Snow\Animation\Wind\NoWind;
use TechBit\Snow\Config\Config;


class NoWindPreset extends Config
{

    public function windForces(): array
    {
        return [
            NoWind::class,
        ];
    }

}