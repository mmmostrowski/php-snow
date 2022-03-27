<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation\Snow;

use TechBit\Snow\SnowFallAnimation\AnimationContext;
use TechBit\Snow\SnowFallAnimation\Config\Config;
use TechBit\Snow\SnowFallAnimation\Frame\FramePainter;
use TechBit\Snow\SnowFallAnimation\Object\IAnimationVisibleObject;
use TechBit\Snow\Console\IConsole;


final class Snow implements IAnimationVisibleObject
{

    private readonly SnowBasis $basis;

    private readonly SnowParticles $particles;

    private readonly FramePainter $renderer;

    private readonly IConsole $console;

    private readonly SnowFlakeShape $shapes;

    private readonly int $howMuchSnowIsGeneratedAtTop;

    private readonly Config $config;


    public function initialize(AnimationContext $context): void
    {
        $this->shapes = $context->snowFlakeShape();
        $this->console = $context->console();
        $this->config = $context->config();
        $this->howMuchSnowIsGeneratedAtTop = $context->config()->snowProbabilityOfProducingFromTop();

        $this->particles = $context->snowParticles();
        $this->renderer = $context->painter();
        $this->basis = $context->snowBasis();
    }

    public function renderFirstFrame(): void
    {
    }

    public function renderLoopFrame(): void
    {
        for ($i = 0; $i < $this->numOfSnowflakesToGenerate(); ++$i) {
            $newParticle = $this->generateFlakeParticle();
            if ($this->basis->isHitAt($newParticle[SnowParticles::X], $newParticle[SnowParticles::Y])) {
                continue;
            }

            $idx = $this->particles->addNew($newParticle);
            $this->renderer->renderParticle($idx);
        }
    }

    private function numOfSnowflakesToGenerate(): int
    {
        if ($this->particles->count() >= $this->config->snowMaxNumOfFlakesAtOnce()) {
            return 0;
        }

        $generationSpeed = $this->config->snowProducingTempo();

        if ($generationSpeed < 100) {
            return rand(0, 100) < $generationSpeed ? 1 : 0;
        }

        return min((int)($generationSpeed / 100), $this->config->snowMaxNumOfFlakesAtOnce());
    }

    private function generateFlakeParticle(): array
    {
        $shape = $this->shapes->randomShape();

        if (rand(0, 100) <= $this->howMuchSnowIsGeneratedAtTop) {
            return $this->randomAtTop($shape);
        }
        return $this->randomInCenterArea($shape);
    }

    private function randomAtTop(string $shape): array
    {
        $halfWidth = (int)($this->console->width() / 2);

        return $this->particles->makeNew(
            rand((int)$this->console->minX() - $halfWidth, (int)$this->console->maxX() + $halfWidth),
            $this->console->minY(),
            $shape,
        );
    }

    private function randomInCenterArea(string $shape): array
    {
        return $this->particles->makeNew(
            rand((int)$this->console->minX(), (int)$this->console->maxX()),
            rand((int)$this->console->minY(), (int)$this->console->maxY()),
            $shape,
        );
    }

}