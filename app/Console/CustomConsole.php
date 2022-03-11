<?php


namespace TechBit\Snow\Console;


class CustomConsole extends Console
{


    /**
     * @var int
     */
    private $overriddenMaxX = 0;

    /**
     * @var int
     */
    private $overriddenMinX = 0;

    /**
     * @var int
     */
    private $overriddenMaxY = 0;

    /**
     * @var int
     */
    private $overriddenMinY = 0;

    /**
     * @var bool
     */
    private $overriddenWindow = false;


    public function overrideWindow($minX, $maxX, $minY, $maxY)
    {
        $this->overriddenWindow = true;
        $this->overriddenMaxX = (int)$maxX;
        $this->overriddenMinX = (int)$minX;
        $this->overriddenMaxY = (int)$maxY;
        $this->overriddenMinY = (int)$minY;
    }

    public function minX()
    {
        return $this->overriddenMinX;
    }

    public function maxX()
    {
        return $this->overriddenMaxX;
    }

    public function minY()
    {
        return $this->overriddenMinY;
    }

    public function maxY()
    {
        return $this->overriddenMaxY;
    }


}