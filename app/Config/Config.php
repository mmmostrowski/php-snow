<?php namespace TechBit\Snow\Config;

use TechBit\Snow\Animation\Wind\BlowWind;
use TechBit\Snow\Animation\Wind\FieldWind;
use TechBit\Snow\Animation\Wind\MicroWavingWind;
use TechBit\Snow\Animation\Wind\StaticWind;


class Config
{

    public function minRequiredConsoleWidth()
    {
        return 170;
    }

    public function minRequiredConsoleHeight()
    {
        return 40;
    }

    public function animationLengthInFrames()
    {
        return 15000;
    }

    public function fps()
    {
        return 27;
    }

    public function showFps()
    {
        return false;
    }

    public function showScene()
    {
        return true;
    }

    public function gravity()
    {
        return 0.45;
    }

    public function microMovementPower()
    {
        return 0.3;
    }

    public function microMovementFrequency()
    {
        return 0.6;
    }

    public function windGlobalVariation()
    {
        return 1.0;
    }

    public function windGlobalStrengthMin()
    {
        return 1.0;
    }

    public function windGlobalStrengthMax()
    {
        return 5.0;
    }

    public function windFieldVariation()
    {
        return 3.0;
    }

    public function windFieldStrengthMin()
    {
        return -10;
    }

    public function windFieldStrengthMax()
    {
        return 40;
    }

    public function windFieldGridUpdateEveryNthFrame()
    {
        return 5;
    }

    public function windFieldGridSize()
    {
        return 3;
    }

    public function snowProducingTempo()
    {
        return 100;
    }

    public function snowMaxNumOfFlakesAtOnce()
    {
        return 2000;
    }

    public function snowProbabilityOfProducingFromTop()
    {
        return 70;
    }

    public function snowHowManyFlakesNeedsToFallToFormAHill()
    {
        return 2;
    }

    public function snowIsPressedAfterFramesNumMin()
    {
        return 55;
    }

    public function snowIsPressedAfterFramesNumMax()
    {
        return 888;
    }

    public function windBlowsFrequency()
    {
        return 20;
    }

    public function windBlowsMaxNumAtSameTime()
    {
        return 1;
    }

    public function windBlowsMinStrength()
    {
        return 1;
    }

    public function windBlowsMaxStrength()
    {
        return 3;
    }

    public function windBlowsMinAnimationLength()
    {
        return 60;
    }

    public function windBlowsMaxAnimationLength()
    {
        return 100;
    }

    public function windForces()
    {
        return [
            StaticWind::class,
            FieldWind::class,
            BlowWind::class,
            MicroWavingWind::class,
        ];
    }

}