<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation\Config;


class StartupConfig
{
    
    public function minRequiredConsoleWidth(): int
    {
        return 170;
    }

    public function minRequiredConsoleHeight(): int
    {
        return 40;
    }

    public function targetFps(): int
    {
        return 33;
    }

    public function animationLengthInFrames(): int
    {
        return $this->targetFps() * 60 * 10; # 10 min
    }

    public function showScene(): bool
    {
        return true;
    }

    public function sliderMinDurationSec(): int
    {
        return 5;
    }

    public function sliderMaxDurationSec(): int
    {
        return 25;
    }

    public function sliderMinFadeTimeSec(): int
    {
        return 3;
    }

    public function sliderMaxFadeTimeSec(): int
    {
        return 15;
    }

}