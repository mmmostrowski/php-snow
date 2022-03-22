<?php declare(strict_types=1);

namespace TechBit\Snow\Animation\Renderer;

use TechBit\Snow\Animation\Snow\ParticlesSet;
use TechBit\Snow\Console\Console;
use TechBit\Snow\Console\ConsoleColor;


class Renderer
{

    public function __construct(
        protected readonly Console $console,
        protected readonly ParticlesSet $set)
    {
    }

    public function eraseParticle(int $idx): void
    {
        $this->console->printAt(
            (int)$this->set->x($idx),
            (int)$this->set->y($idx),
            ' '
        );
    }

    public function renderParticle(int $idx): void
    {
        $this->console->printAt(
            $this->set->x($idx),
            $this->set->y($idx),
            $this->set->shape($idx)
        );
    }

    public function renderBasisParticle(int $x, int $y, $shape): void
    {
        $this->console->printAt($x, $y, $shape);
    }

    public function renderBackgroundParticle(float $x, float $y, string $char, ConsoleColor $color): void
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