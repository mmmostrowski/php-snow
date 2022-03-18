<?php declare(strict_types=1);

namespace TechBit\Snow\Animation\Snow;

use TechBit\Snow\Animation\Object\IAnimationAliveObject;
use TechBit\Snow\Animation\Object\IAnimationVisibleObject;
use TechBit\Snow\Animation\Renderer\Renderer;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Console\Console;
use TechBit\Snow\Console\ConsoleColor;


class SnowBasis implements IAnimationAliveObject, IAnimationVisibleObject
{
    const SHAPE = 0;
    const COUNTER = 1;

    protected array $staticParticles = [];

    protected array $particlesToBePressed = [];

    protected int $pressingSpeedMin = 0;

    protected int $pressingSpeedMax = 0;

    protected int $howManyParticlesNeedsToFallToBecomeGround = 0;

    protected int $counter = 0;

    protected string $pressedSnowSymbol = '';


    public function __construct(
        protected readonly Console $console,
        protected readonly FlakeShapes $shapes,
        protected readonly Config $config,
        protected readonly Renderer $renderer )
    {
        $this->pressedSnowSymbol = $this->shapes->pressedSnowSymbol();
    }

    public function initialize(): void
    {
        $this->howManyParticlesNeedsToFallToBecomeGround = $this->config->snowHowManyFlakesNeedsToFallToFormAHill();
        $this->pressingSpeedMin = $this->config->snowIsPressedAfterFramesNumMin();
        $this->pressingSpeedMax = $this->config->snowIsPressedAfterFramesNumMax();
        $this->counter = 0;
    }

    public function update(): void
    {
        $this->processSnowFlakesPressing();
        ++$this->counter;
    }

    public function renderFirstFrame(): void
    {
    }

    public function renderLoopFrame(): void
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

    public function drawGround(): void
    {
        $this->drawHLine($this->console->minX(), $this->console->maxX(), $this->console->maxY());
    }

    public function mergeParticle(float $x, float $y, string $shape): void
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

    protected function mergePoint(float $x, float $y, string $shape): void
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

    protected function addPointForPressing(float $x, float $y): void
    {
        $x = (int)$x;
        $y = (int)$y;

        $this->particlesToBePressed[$x][$y] = rand($this->pressingSpeedMin, $this->pressingSpeedMax);
    }

    public function isHitAt(float $x, float $y): bool
    {
        $x = (int)$x;
        $y = (int)$y;

        return isset($this->staticParticles[$x][$y]);
    }

    public function drawChars(string $chars, float $posX, float $posY, ConsoleColor $color): void
    {
        $lines = explode(PHP_EOL, $chars);

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

    public function drawCharsInCenter(string $chars, float $dx, float $dy, ConsoleColor $color): void
    {
        $this->drawChars(
            $chars,
            $this->console->centerX() + $dx,
            $this->console->centerY() + $dy,
            $color
        );
    }

    protected function processSnowFlakesPressing(): void
    {
        foreach ($this->particlesToBePressed as $x => &$list) {
            foreach ($list as $y => &$counter) {
                if (--$counter >= 0) {
                    continue;
                }

                $this->mergePoint($x, $y, $this->pressedSnowSymbol);
                unset($this->particlesToBePressed[$x][$y]);
            }
        }
    }

    protected function addPoint(float $x, float $y, string $shape): void
    {
        $x = (int)$x;
        $y = (int)$y;

        $this->staticParticles[$x][$y] = [
            self::SHAPE => $shape,
            self::COUNTER => 0,
        ];
    }

    protected function drawHLine(float $minX, float $maxX, float $y): void
    {
        for ($x = $minX; $x <= $maxX; ++$x) {
            $this->drawPoint($x, $y);
        }
    }

    protected function drawPoint(float $x, float $y): void
    {
        $this->addPoint($x, $y, '');
    }

}