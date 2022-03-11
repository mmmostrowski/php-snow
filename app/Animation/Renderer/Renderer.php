<?php namespace TechBit\Snow\Animation\Renderer;

use TechBit\Snow\Animation\Snow\ParticlesSet;
use TechBit\Snow\Console\Console;


class Renderer
{

    /**
     * @var Console
     */
    protected $console;

    /**
     * @var ParticlesSet
     */
    protected $set;


    public function __construct(Console $console, ParticlesSet $set)
    {
        $this->console = $console;
        $this->set = $set;
    }

    public function removeParticle($idx)
    {
        $this->console->printAt(
            $this->set->x($idx),
            $this->set->y($idx),
            ' '
        );
    }

    public function renderParticle($idx)
    {
        $this->console->printAt(
            $this->set->x($idx),
            $this->set->y($idx),
            $this->set->shape($idx)
        );
    }

    public function renderBasisParticle($x, $y, $shape)
    {
        $this->console->printAt($x, $y, $shape);
    }

    public function renderBackgroundParticle($x, $y, $char, $color)
    {
        $this->console->enableColor($color);
        $this->console->printAt($x, $y, $char);
        $this->console->clearFormatting();
    }

    public function clearWholeWindow()
    {
        $this->console->clear();
    }

}