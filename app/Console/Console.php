<?php namespace TechBit\Snow\Console;


class Console
{

    /**
     * @var string[]
     */
    protected $colors = [
        'blue' => "\e[34m",
        'light_blue' => "\e[94m",
        'green' => "\e[32m",
    ];

    /**
     * @var int
     */
    protected $cols = 0;

    /**
     * @var int
     */
    protected $rows = 0;

    /**
     * @var int
     */
    protected $refreshingCounter = 0;

    public function __construct()
    {
        $this->refreshConsoleSize();
        register_shutdown_function(function () {
            echo "\033[?25h";
        });
    }

    public function minX()
    {
        return (int)0;
    }

    public function maxX()
    {
        return (int)$this->cols;
    }

    public function minY()
    {
        return (int)0;
    }

    public function maxY()
    {
        return (int)$this->rows;
    }

    public function printAt($x, $y, $txt)
    {
        $this->refreshConsoleSize();

        $x = (int)$x;
        $y = (int)$y;

        if ($x < $this->minX() || $x > $this->maxX()) {
            return;
        }

        if ($y < $this->minY() || $y > $this->maxY()) {
            return;
        }

        echo "\033[?25l";
        echo "\033[{$y};{$x}H";

        echo $txt;
    }

    public function enableColor($color)
    {
        if ($color === null) {
            return;
        }

        if (!isset($this->colors[$color])) {
            throw new \Exception("Invalid color: $color");
        }

        echo $this->colors[$color];
    }

    public function clearFormatting()
    {
        echo "\e[0m";
    }

    public function width()
    {
        return $this->maxX() - $this->minX();
    }

    public function height()
    {
        return $this->maxY() - $this->minY();
    }

    public function isIn($x, $y)
    {
        return $x >= $this->minX() && $x <= $this->maxX()
            && $y >= $this->minY() && $y <= $this->maxY();
    }

    public function notIn($x, $y)
    {
        return $x < $this->minX() || $x > $this->maxX()
            || $y < $this->minY() || $y > $this->maxY();
    }

    public function centerX()
    {
        return ($this->maxX() - $this->minX()) / 2;
    }

    public function centerY()
    {
        return ($this->maxY() - $this->minY()) / 2;
    }

    protected function refreshConsoleSize()
    {
        if (0 == $this->refreshingCounter++ % 500) {
            $this->cols = exec('tput cols');
            $this->rows = exec('tput lines');
        }
    }

    public function clear()
    {
        for ($y = $this->minY(); $y <= $this->maxY(); ++$y) {
            for ($x = $this->minX(); $x <= $this->maxX(); ++$x) {
                $this->printAt($x, $y, ' ');
            }
        }
    }

}