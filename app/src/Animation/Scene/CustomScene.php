<?php declare(strict_types=1);

namespace TechBit\Snow\Animation\Scene;

use TechBit\Snow\Animation\Object\IAnimationVisibleObject;
use TechBit\Snow\Animation\Snow\SnowBasis;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Console\Console;
use TechBit\Snow\Console\ConsoleColor;


class CustomScene implements IAnimationVisibleObject
{

    protected readonly string $sceneTxt;

    public function __construct(
        protected readonly Config $config,
        protected readonly SnowBasis $basis,
        protected readonly Console $console)
    {
    }

    public function setupScene(string $sceneTxt): void
    {
        $this->sceneTxt = $sceneTxt;
    }

    public function initialize(): void
    {
    }

    public function renderFirstFrame(): void
    {
        if (!$this->config->showScene()) {
            return;
        }

        $this->basis->drawGround();

        $this->basis->drawCharsInCenter(
            $this->sceneTxt,
            0, 0,
            ConsoleColor::LIGHT_BLUE
        );
    }

    public function renderLoopFrame(): void
    {
    }

}