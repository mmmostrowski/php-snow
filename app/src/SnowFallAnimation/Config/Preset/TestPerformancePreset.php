<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation\Config\Preset;

use TechBit\Snow\SnowFallAnimation\Config\Config;


final class TestPerformancePreset extends Config
{

    public function showFps(): bool
    {
        return true;
    }

    public function targetFps(): int
    {
        return 10000;
    }

    public function snowProducingTempo(): int
    {
        return parent::snowProducingTempo() * 250;
    }

    public function snowMaxNumOfFlakesAtOnce(): int
    {
        return parent::snowMaxNumOfFlakesAtOnce() * 250;
    }

    public function snowHowManyFlakesNeedsToFallToFormAHill(): int
    {
        return parent::snowHowManyFlakesNeedsToFallToFormAHill() * 30;
    }

}
