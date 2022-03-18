<?php declare(strict_types=1);

namespace TechBit\Snow\Console;


class CustomConsole extends Console
{

    private float $overriddenMaxX = 0.0;

    private float $overriddenMinX = 0.0;

    private float $overriddenMaxY = 0.0;

    private float $overriddenMinY = 0.0;


    public function overrideWindow(float $minX, float $maxX, float $minY, float $maxY)
    {
        $this->overriddenMaxX = $maxX;
        $this->overriddenMinX = $minX;
        $this->overriddenMaxY = $maxY;
        $this->overriddenMinY = $minY;
    }

    public function minX(): float
    {
        return $this->overriddenMinX;
    }

    public function maxX(): float
    {
        return $this->overriddenMaxX;
    }

    public function minY(): float
    {
        return $this->overriddenMinY;
    }

    public function maxY(): float
    {
        return $this->overriddenMaxY;
    }

}
