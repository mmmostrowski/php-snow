<?php


namespace TechBit\Snow\Animation\Snow;


use TechBit\Snow\Animation\Object\IAnimationAliveObject;
use TechBit\Snow\Animation\Object\IAnimationVisibleObject;
use TechBit\Snow\Animation\Renderer\Renderer;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Console\Console;
use TechBit\Snow\Math\Interpolation;

class SnowBasis implements IAnimationAliveObject, IAnimationVisibleObject
{
    const SHAPE = 0;
    const COUNTER = 1;

    /**
     * @var Interpolation
     */
    protected $interpolator;

    /**
     * @var array[]
     */
    protected $staticParticles = [];

    /**
     * @var Console
     */
    protected $console;

    /**
     * @var FlakeShapes
     */
    protected $shapes;

    /**
     * @var array[]
     */
    protected $particlesToBePressed = [];

    /**
     * @var int
     */
    protected $pressingSpeedMin = 0;

    /**
     * @var int
     */
    protected $pressingSpeedMax = 0;

    /**
     * @var
     */
    protected $howManyParticlesNeedsToFallToBecomeGround = 0;

    /**
     * @var Config
     */
    protected $config;
    /**
     * @var Renderer
     */
    protected $renderer;

    /**
     * @var int
     */
    protected $counter = 0;

    /**
     * @var string
     */
    protected $pressedSnowSymbol = '';


    public function __construct(Console $console, FlakeShapes $shapes, Config $config, Renderer $renderer)
    {
        $this->console = $console;
        $this->shapes = $shapes;
        $this->config = $config;
        $this->renderer = $renderer;
        $this->pressedSnowSymbol = $this->shapes->pressedSnowSymbol();
    }

    public function initialize()
    {
        $this->howManyParticlesNeedsToFallToBecomeGround = $this->config->snowHowManyFlakesNeedsToFallToFormAHill();
        $this->pressingSpeedMin = $this->config->snowIsPressedAfterFramesNumMin();
        $this->pressingSpeedMax = $this->config->snowIsPressedAfterFramesNumMax();
        $this->counter = 0;
    }

    public function update()
    {
        $this->processSnowFlakesPressing();
        ++$this->counter;
    }

    public function renderFirstFrame()
    {
    }

    public function renderLoopFrame()
    {
        if ($this->counter % 15 != 0) {
            return;
        }

        foreach ($this->staticParticles as $x => $list) {
            foreach ($list as $y => $particle) {
                $this->renderer->renderBasisParticle($x, $y, $particle[self::SHAPE]);
            }
        }
    }

    public function draw(array $points)
    {
        foreach ($points as $point) {
            $this->drawPoint($point['x'], $point['y']);
        }
    }

    public function drawPoint($x, $y)
    {
        $this->addPoint($x, $y, '');
    }

    public function drawGround()
    {
        $this->drawHLine($this->console->minX(), $this->console->maxX(), $this->console->maxY());
    }

    public function drawVLine($x, $minY, $maxY)
    {
        for ($y = $minY; $y <= $maxY; ++$y) {
            $this->drawPoint($x, $y);
        }
    }

    public function drawHLine($minX, $maxX, $y)
    {
        for ($x = $minX; $x <= $maxX; ++$x) {
            $this->drawPoint($x, $y);
        }
    }

    protected function addPoint($x, $y, $shape)
    {
        $x = (int)$x;
        $y = (int)$y;

        $this->staticParticles[$x][$y] = [
            self::SHAPE => $shape,
            self::COUNTER => 0,
        ];
    }

    protected function mergePoint($x, $y, $shape)
    {
        $x = (int)$x;
        $y = (int)$y;

        if ($this->staticParticles[$x][$y][self::SHAPE] != $this->pressedSnowSymbol) {
            $this->staticParticles[$x][$y][self::SHAPE] = $shape;
        }

        if (!isset($this->staticParticles[$x][$y][self::COUNTER])) {
            $this->staticParticles[$x][$y][self::COUNTER] = 0;
        }
    }

    protected function addPointForPressing($x, $y)
    {
        $this->particlesToBePressed[(int)$x][(int)$y] = rand($this->pressingSpeedMin, $this->pressingSpeedMax);
    }

    public function mergeParticle($x, $y, $shape)
    {
        $x = (int)$x;
        $y = (int)$y;

        if (++$this->staticParticles[$x][$y][self::COUNTER] >= $this->howManyParticlesNeedsToFallToBecomeGround) {
            if (($this->isHitAt($x - 1, $y) || ($x == $this->console->minX() + 1))
                && ($this->isHitAt($x + 1, $y) || ($x == $this->console->maxX() - 1))
            ) {
                $this->addPoint($x, $y - 1, $shape);
            }
        } else {
            $this->mergePoint($x, $y, $shape);
            $this->addPointForPressing($x, $y);
        }
    }

    public function isHitAt($x, $y)
    {
        return isset($this->staticParticles[(int)$x][(int)$y]);
    }

    public function drawChars($chars, $posX, $posY, $color)
    {
        $lines = [];
        foreach (explode(PHP_EOL, $chars) as $line) {
            if (!trim($line)) {
                continue;
            }
            $lines[] = $line;
        }

        $height = count($lines);
        $width = 0;
        foreach ($lines as $line) {
            $width = max($width, strlen(trim($line)));
        }

        for ($y = 0; $y < $height; ++$y) {
            $pY = $y + $posY - $height / 2;
            for ($x = 0; $x < $width; ++$x) {
                $pX = $x + $posX - $width / 2;
                $c = @$lines[$y][$x];

                if ($c != ' ' && $c !== null && $c !== '') {
                    $this->drawPoint($pX, $pY);
                    $this->renderer->renderBackgroundParticle($pX, $pY, $c, $color);
                }
            }
            echo PHP_EOL;
        }
    }

    public function drawCharsInCenter($chars, $dx, $dy, $color)
    {
        $this->drawChars(
            $chars,
            $this->console->centerX() + $dx,
            $this->console->centerY() + $dy,
            $color
        );
    }

    protected function processSnowFlakesPressing()
    {
        foreach ($this->particlesToBePressed as $x => &$list) {
            foreach ($list as $y => &$counter) {
                if (--$counter <= 0) {
                    $this->mergePoint($x, $y, $this->pressedSnowSymbol);
                    unset($this->particlesToBePressed[$x][$y]);
                }
            }
        }
    }
}