<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation\Config\Preset;

use TechBit\Snow\SnowFallAnimation\Config\Config;


final class TestWindPreset extends Config
{

//    public function fps()
//    {
//        return 100000;
//    }

    public function snowProbabilityOfProducingFromTop(): int
    {
        return 0;
    }
//
//    public function gravity()
//    {
//        return 0;
//    }

    public function windGlobalStrengthMin(): float
    {
        return 0.0;
    }

    public function windGlobalStrengthMax(): float
    {
        return 0.0;

    }
//
//    public function windFieldVariation()
//    {
//        return 4.0;
//    }
//

//    public function windFieldPowerMin()
//    {
//        return 0;
//    }
//
//    public function windFieldPowerMax()
//    {
//        return 0;
//    }

    public function snowProducingTempo(): int
    {
        return parent::snowProducingTempo() * 3;
    }

    public function snowMaxNumOfFlakesAtOnce(): int
    {
        return parent::snowMaxNumOfFlakesAtOnce() * 3;
    }

//    public function microMovementFrequency()
//    {
//        return 0;
//    }
//
    public function microMovementPower(): float
    {
        return 0.0;
    }

    public function showScene(): bool
    {
        return false;
    }

    public function showFps(): bool
    {
        return true;
    }

}