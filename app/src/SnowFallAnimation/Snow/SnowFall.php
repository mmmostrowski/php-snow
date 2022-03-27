<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation\Snow;

use TechBit\Snow\SnowFallAnimation\AnimationContext;
use TechBit\Snow\SnowFallAnimation\Frame\FramePainter;
use TechBit\Snow\SnowFallAnimation\Object\IAnimationVisibleObject;
use TechBit\Snow\SnowFallAnimation\Wind\IWind;
use TechBit\Snow\Console\IConsole;


final class SnowFall implements IAnimationVisibleObject
{
    private readonly SnowBasis $basis;

    private readonly SnowParticles $particles;

    private readonly FramePainter $renderer;

    private readonly IConsole $console;

    private readonly IWind $wind;

    private readonly float $gravityConstant;


    public function initialize(AnimationContext $context): void
    {
        $this->gravityConstant = $context->config()->gravity();
        $this->particles = $context->snowParticles();
        $this->console = $context->console();
        $this->renderer = $context->painter();
        $this->basis = $context->snowBasis();
        $this->wind = $context->wind();
    }

    public function renderFirstFrame(): void
    {
    }

    public function renderLoopFrame(): void
    {
        foreach ($this->particles->all() as $idx => $data) {
            if ($this->basis->isHitAt($data[SnowParticles::X], $data[SnowParticles::Y])) {
                $this->basis->mergeParticle($data[SnowParticles::X], $data[SnowParticles::Y], $data[SnowParticles::SHAPE]);
                $this->particles->remove($idx);
                continue;
            }

            $this->renderer->eraseParticle($idx);

            $this->moveParticle($idx);

            if ($this->console->notIn($data[SnowParticles::X], $data[SnowParticles::Y])) {
                $this->particles->remove($idx);
                continue;
            }

            if ($this->basis->isHitAt($this->particles->x($idx), $this->particles->y($idx))) {
                continue;
            }

            $this->renderer->renderParticle($idx);
        }
    }

    private function moveParticle(int $idx): void
    {
        // Wind
        $this->wind->moveParticle($idx);

        // Gravity
        $this->particles->moveByY($idx, $this->gravityConstant);

        // Momentum
        $this->particles->moveByMomentum($idx);
    }

}