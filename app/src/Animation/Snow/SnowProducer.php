<?php declare(strict_types=1);

namespace TechBit\Snow\Animation\Snow;

use TechBit\Snow\Animation\Object\IAnimationVisibleObject;
use TechBit\Snow\Animation\Renderer\Renderer;
use TechBit\Snow\Config\Config;


class SnowProducer implements IAnimationVisibleObject
{

    public function __construct(
        protected readonly SnowGenerator $generator,
        protected readonly ParticlesSet $particles,
        protected readonly Renderer $renderer,
        protected readonly Config $config,
        protected readonly SnowBasis $basis )
    {
    }

    public function initialize(): void
    {
    }

    public function renderFirstFrame(): void
    {
    }

    public function renderLoopFrame(): void
    {
        for ($i = 0; $i < $this->numOfSnowflakesToGenerate(); ++$i) {
            $newParticle = $this->generator->generateFlakeParticle();
            if ($this->basis->isHitAt($newParticle[ParticlesSet::X], $newParticle[ParticlesSet::Y])) {
                continue;
            }

            $idx = $this->particles->addNew($newParticle);
            $this->renderer->renderParticle($idx);
        }
    }

    protected function numOfSnowflakesToGenerate(): int
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
}