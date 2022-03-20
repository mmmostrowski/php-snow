<?php declare(strict_types=1);

namespace TechBit\Snow\Config\Preset;

use TechBit\Snow\Animation\Wind\NoWind;
use TechBit\Snow\Config\Config;


class NoSnowPreset extends Config
{

    public function windForces(): array
    {
        return [
            NoWind::class,
        ];
    }

    public function snowMaxNumOfFlakesAtOnce(): int
    {
        return 0;
    }

}