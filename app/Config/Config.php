<?php declare(strict_types=1);

namespace TechBit\Snow\Config;

use TechBit\Snow\Animation\Wind\BlowWind;
use TechBit\Snow\Animation\Wind\FieldWind;
use TechBit\Snow\Animation\Wind\MicroWavingWind;
use TechBit\Snow\Animation\Wind\StaticWind;


class Config
{

    public function windForces(): array
    {
        return [
            StaticWind::class,
            FieldWind::class,
            BlowWind::class,
            MicroWavingWind::class,
        ];
    }

    public function minRequiredConsoleWidth(): int
    {
        return 170;
    }

    public function minRequiredConsoleHeight(): int
    {
        return 40;
    }

    public function animationLengthInFrames(): int
    {
        return 15000;
    }

    public function fps(): int
    {
        return 33;
    }

    public function showFps(): bool
    {
        return false;
    }

    public function showScene(): bool
    {
        return true;
    }

    public function gravity(): float
    {
        return 0.45;
    }

    public function microMovementPower(): float
    {
        return 0.3;
    }

    public function microMovementFrequency(): float
    {
        return 0.6;
    }

    public function windGlobalVariation(): float
    {
        return 1.0;
    }

    public function windGlobalStrengthMin(): float
    {
        return 1.0;
    }

    public function windGlobalStrengthMax(): float
    {
        return 5.0;
    }

    public function windFieldVariation(): float
    {
        return 3.0;
    }

    public function windFieldStrengthMin(): int
    {
        return -10;
    }

    public function windFieldStrengthMax(): int
    {
        return 40;
    }

    public function windFieldGridUpdateEveryNthFrame(): int
    {
        return 5;
    }

    public function windFieldGridSize(): int
    {
        return 3;
    }

    public function snowProducingTempo(): int
    {
        return 100;
    }

    public function snowMaxNumOfFlakesAtOnce(): int
    {
        return 2000;
    }

    public function snowProbabilityOfProducingFromTop(): int
    {
        return 70;
    }

    public function snowHowManyFlakesNeedsToFallToFormAHill(): int
    {
        return 2;
    }

    public function snowIsPressedAfterFramesNumMin(): int
    {
        return 55;
    }

    public function snowIsPressedAfterFramesNumMax(): int
    {
        return 888;
    }

    public function windBlowsFrequency(): int
    {
        return 20;
    }

    public function windBlowsMaxNumAtSameTime(): int
    {
        return 1;
    }

    public function windBlowsMinStrength(): int
    {
        return 1;
    }

    public function windBlowsMaxStrength(): int
    {
        return 3;
    }

    public function windBlowsMinAnimationLength(): int
    {
        return 60;
    }

    public function windBlowsMaxAnimationLength(): int
    {
        return 100;
    }

}