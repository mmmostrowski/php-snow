<?php declare(strict_types=1);

namespace TechBit\Snow\Animation\Snow;

use TechBit\Snow\Animation\Object\IAnimationObject;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Console\Console;


class SnowGenerator implements IAnimationObject
{

    protected int $howMuchSnowIsGeneratedAtTop;

    protected array $nullParticle = [
        ParticlesSet::X => -1,
        ParticlesSet::Y => -1,
        ParticlesSet::SHAPE => '',
        ParticlesSet::MOMENTUM_X => 0.0,
        ParticlesSet::MOMENTUM_Y => 0.0,
    ];


    public function __construct(
        protected readonly Config $config,
        protected readonly Console $console,
        protected readonly FlakeShapes $shapes)
    {
    }

    public function initialize(): void
    {
        $this->howMuchSnowIsGeneratedAtTop = $this->config->snowProbabilityOfProducingFromTop();
    }

    public function generateFlakeParticle(): array
    {
        $shape = $this->shapes->randomShape();

        if (rand(0, 100) <= $this->howMuchSnowIsGeneratedAtTop) {
            return $this->randomAtTop($shape);
        }
        return $this->randomInCenterArea($shape);
    }

    protected function randomAtTop(string $shape): array
    {
        $halfWidth = (int)($this->console->width() / 2);
        return [
                ParticlesSet::X => rand((int)$this->console->minX() - $halfWidth, (int)$this->console->maxX() + $halfWidth),
                ParticlesSet::Y => $this->console->minY(),
                ParticlesSet::SHAPE => $shape,
            ] + $this->nullParticle;
    }

    protected function randomInCenterArea(string $shape): array
    {
        return [
                ParticlesSet::X => rand((int)$this->console->minX(), (int)$this->console->maxX()),
                ParticlesSet::Y => rand((int)$this->console->minY(), (int)$this->console->maxY()),
                ParticlesSet::SHAPE => $shape,
            ] + $this->nullParticle;
    }

}