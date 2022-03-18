<?php declare(strict_types=1);

namespace TechBit\Snow\Animation\Snow;

use TechBit\Snow\Animation\Object\IAnimationVisibleObject;
use TechBit\Snow\Animation\Renderer\Renderer;
use TechBit\Snow\Animation\Wind\IWind;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Console\Console;


class SnowAnimator implements IAnimationVisibleObject
{
    protected float $gravityConstant = 0.0;

    public function __construct(
        protected readonly ParticlesSet $particles,
        protected readonly SnowBasis $basis,
        protected readonly Renderer $renderer,
        protected readonly Console $console,
        protected readonly Config $config,
        protected readonly IWind $wind)
    {
    }

    public function initialize(): void
    {
        $this->gravityConstant = $this->config->gravity();
    }

    public function renderFirstFrame(): void
    {
    }

    public function renderLoopFrame(): void
    {
        foreach ($this->particles->all() as $idx => $data) {
            if ($this->basis->isHitAt($data[ParticlesSet::X], $data[ParticlesSet::Y])) {
                $this->basis->mergeParticle($data[ParticlesSet::X], $data[ParticlesSet::Y], $data[ParticlesSet::SHAPE]);
                $this->particles->remove($idx);
                continue;
            }

            $this->renderer->removeParticle($idx);

            $this->moveParticle($idx);

            if ($this->console->notIn($data[ParticlesSet::X], $data[ParticlesSet::Y])) {
                $this->particles->remove($idx);
                continue;
            }

            if ($this->basis->isHitAt($this->particles->x($idx), $this->particles->y($idx))) {
                continue;
            }

            $this->renderer->renderParticle($idx);
        }
    }

    public function moveParticle(int $idx): void
    {
        // Wind
        $this->wind->moveParticle($idx);

        // Gravity
        $this->particles->moveByY($idx, $this->gravityConstant);

        // Momentum
        $this->particles->moveByMomentum($idx);
    }
    
}