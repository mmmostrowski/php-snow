<?php declare(strict_types=1);

namespace TechBit\Snow\Config\Preset;

use TechBit\Snow\Config\Config;


class TestPerformancePreset extends Config
{

    public function fps(): int
    {
        return 10000;
    }

    public function snowProducingTempo(): int
    {
        return parent::snowProducingTempo() * 100;
    }

    public function showFps(): bool
    {
        return true;
    }

}
