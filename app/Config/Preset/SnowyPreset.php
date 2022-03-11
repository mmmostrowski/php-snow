<?php

namespace TechBit\Snow\Config\Preset;

use TechBit\Snow\Config\Config;


class SnowyPreset extends Config
{

    public function snowProducingTempo()
    {
        return parent::snowProducingTempo() * 10;
    }

    public function snowProbabilityOfProducingFromTop()
    {
        return parent::snowProbabilityOfProducingFromTop() - 10;
    }

    public function snowMaxNumOfFlakesAtOnce()
    {
        return parent::snowMaxNumOfFlakesAtOnce() * 0.25;
    }

    public function snowIsPressedAfterFramesNumMin()
    {
        return parent::snowIsPressedAfterFramesNumMin() * 3;
    }

    public function snowIsPressedAfterFramesNumMax()
    {
        return parent::snowIsPressedAfterFramesNumMax() * 3;
    }

}