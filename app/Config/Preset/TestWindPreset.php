<?php namespace TechBit\Snow\Config\Preset;

use TechBit\Snow\Config\Config;


class TestWindPreset extends Config
{

//    public function fps()
//    {
//        return 100000;
//    }

    public function snowProbabilityOfProducingFromTop()
    {
        return 0;
    }
//
//    public function gravity()
//    {
//        return 0;
//    }

    public function windGlobalStrengthMin()
    {
        return 0;
    }

    public function windGlobalStrengthMax()
    {
        return 0;

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

    public function snowProducingTempo()
    {
        return parent::snowProducingTempo() * 3;
    }

    public function snowMaxNumOfFlakesAtOnce()
    {
        return parent::snowMaxNumOfFlakesAtOnce() * 3;
    }

//    public function microMovementFrequency()
//    {
//        return 0;
//    }
//
    public function microMovementPower()
    {
        return 0;
    }

    public function showScene()
    {
        return false;
    }

    public function showFps()
    {
        return true;
    }

}