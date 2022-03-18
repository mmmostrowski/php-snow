<?php declare(strict_types=1);

namespace TechBit\Snow\Config\Preset;

use TechBit\Snow\Config\Config;


class SnowyPreset extends Config
{

    public function snowProducingTempo(): int
    {
        return parent::snowProducingTempo() * 10;
    }

    public function snowProbabilityOfProducingFromTop(): int
    {
        return parent::snowProbabilityOfProducingFromTop() - 10;
    }

    public function snowMaxNumOfFlakesAtOnce(): int
    {
        return (int)(parent::snowMaxNumOfFlakesAtOnce() / 4);
    }

    public function snowIsPressedAfterFramesNumMin(): int
    {
        return parent::snowIsPressedAfterFramesNumMin() * 3;
    }

    public function snowIsPressedAfterFramesNumMax():int
    {
        return parent::snowIsPressedAfterFramesNumMax() * 3;
    }

}