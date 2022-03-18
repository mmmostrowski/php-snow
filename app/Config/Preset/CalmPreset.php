<?php declare(strict_types=1);

namespace TechBit\Snow\Config\Preset;

use TechBit\Snow\Config\Config;


class CalmPreset extends Config
{

    public function snowProducingTempo(): int
    {
        return (int)(parent::snowProducingTempo() / 4);
    }

    public function windBlowsMaxStrength(): int
    {
        return (int)(parent::windBlowsMaxStrength() / 3);
    }

    public function windBlowsMinStrength(): int
    {
        return (int)(parent::windBlowsMinStrength() / 3);
    }

    public function windBlowsFrequency(): int
    {
        return (int)(parent::windBlowsFrequency() / 2);
    }

    public function windBlowsMaxAnimationLength(): int
    {
        return (int)(parent::windBlowsMaxAnimationLength() / 6);
    }

    public function windBlowsMinAnimationLength(): int
    {
        return (int)(parent::windBlowsMinAnimationLength() / 6);
    }

    public function windFieldStrengthMax(): int
    {
        return (int)(parent::windFieldStrengthMax() / 10);
    }

    public function windFieldStrengthMin(): int
    {
        return (int)(parent::windFieldStrengthMin() / 10);
    }

    public function windGlobalStrengthMin(): float
    {
        return parent::windGlobalStrengthMin() / 10;
    }

    public function windGlobalStrengthMax(): float
    {
        return parent::windGlobalStrengthMax() / 10;
    }

    public function windFieldVariation(): float
    {
        return parent::windFieldVariation() / 2;
    }

}