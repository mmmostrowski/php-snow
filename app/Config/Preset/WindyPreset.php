<?php

namespace TechBit\Snow\Config\Preset;

use TechBit\Snow\Config\Config;


class WindyPreset extends Config
{

    public function snowProducingTempo()
    {
        return parent::snowProducingTempo() * 5;
    }

    public function snowMaxNumOfFlakesAtOnce()
    {
        return parent::snowMaxNumOfFlakesAtOnce() * 4;
    }

    public function snowProbabilityOfProducingFromTop()
    {
        return parent::snowProbabilityOfProducingFromTop();
    }

    public function windBlowsMaxStrength()
    {
        return parent::windBlowsMaxStrength() * 2;
    }

    public function windBlowsMinStrength()
    {
        return parent::windBlowsMinStrength() * 2;
    }

    public function windBlowsMaxNumAtSameTime()
    {
        return 3;
    }

    public function windBlowsMinAnimationLength()
    {
        return parent::windBlowsMinAnimationLength() / 2;
    }

    public function windBlowsMaxAnimationLength()
    {
        return parent::windBlowsMaxAnimationLength() * 2;
    }

    public function windBlowsFrequency()
    {
        return parent::windBlowsFrequency() * 2;
    }

    public function windGlobalStrengthMax()
    {
        return parent::windGlobalStrengthMax() * 2;
    }

    public function windGlobalStrengthMin()
    {
        return parent::windGlobalStrengthMin() / 2;
    }

    public function windGlobalVariation()
    {
        return parent::windGlobalVariation() * 1.5;
    }

    public function windFieldStrengthMax()
    {
        return parent::windFieldStrengthMax() * 3;
    }

    public function windFieldStrengthMin()
    {
        return parent::windFieldStrengthMin() * 3;
    }


}