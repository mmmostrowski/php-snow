<?php

namespace TechBit\Snow\Config\Preset;

use TechBit\Snow\Config\Config;


class CalmPreset extends Config
{

    public function snowProducingTempo()
    {
        return parent::snowProducingTempo() / 4;
    }

    public function windBlowsMaxStrength()
    {
        return parent::windBlowsMaxStrength() / 3;
    }

    public function windBlowsMinStrength()
    {
        return parent::windBlowsMinStrength() / 3;
    }

    public function windBlowsFrequency()
    {
        return parent::windBlowsFrequency() / 2;
    }

    public function windBlowsMaxAnimationLength()
    {
        return parent::windBlowsMaxAnimationLength() / 6;
    }

    public function windBlowsMinAnimationLength()
    {
        return parent::windBlowsMinAnimationLength() / 6;
    }

    public function windFieldStrengthMax()
    {
        return parent::windFieldStrengthMax() / 10;
    }

    public function windFieldStrengthMin()
    {
        return parent::windFieldStrengthMin() / 10;
    }

    public function windGlobalStrengthMin()
    {
        return parent::windGlobalStrengthMin() / 10;
    }

    public function windGlobalStrengthMax()
    {
        return parent::windGlobalStrengthMax() / 10;
    }

    public function windFieldVariation()
    {
        return parent::windFieldVariation() / 2;
    }

}