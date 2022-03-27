<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation\Frame;

use TechBit\Snow\SnowFallAnimation\AnimationContext;
use TechBit\Snow\SnowFallAnimation\Object\IAnimationObject;
use TechBit\Snow\SnowFallAnimation\Snow\SnowParticles;
use TechBit\Snow\Console\ConsoleColor;
use TechBit\Snow\Console\IConsole;


final class FramePainter implements IFramePainter, IAnimationObject
{

    private readonly SnowParticles $particles;
    private readonly IConsole $console;


    public function initialize(AnimationContext $context): void
    {
        $this->particles = $context->snowParticles();
        $this->console = $context->console();
    }

    public function eraseParticle(int $idx): void
    {
        $this->console->printAt(
            (int)$this->particles->x($idx),
            (int)$this->particles->y($idx),
            ' '
        );
    }

    public function renderParticle(int $idx): void
    {
        $this->console->printAt(
            $this->particles->x($idx),
            $this->particles->y($idx),
            $this->particles->shape($idx)
        );
    }

    public function renderBasisParticle(int $x, int $y, string $shape): void
    {
        $this->console->printAt($x, $y, $shape);
    }

    public function renderBackgroundPixel(float $x, float $y, string $char, ConsoleColor $color): void
    {
        $this->console->switchToColor($color);
        $this->console->printAt($x, $y, $char);
        $this->console->resetColor();
    }

    public function clearWindow(): void
    {
        $this->console->clear();
    }
}