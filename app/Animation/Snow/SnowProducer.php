<?php namespace TechBit\Snow\Animation\Snow;

use TechBit\Snow\Animation\Object\IAnimationVisibleObject;
use TechBit\Snow\Animation\Renderer\Renderer;
use TechBit\Snow\Config\Config;


class SnowProducer implements IAnimationVisibleObject
{

    /**
     * @var SnowGenerator
     */
    protected $generator;

    /**
     * @var ParticlesSet
     */
    protected $particles;

    /**
     * @var Renderer
     */
    protected $renderer;

    /**
     * @var Config
     */
    protected $config;
    /**
     * @var SnowBasis
     */
    private $basis;

    public function __construct(SnowGenerator $generator, ParticlesSet $particles, Renderer $renderer, Config $config, SnowBasis $basis)
    {
        $this->generator = $generator;
        $this->particles = $particles;
        $this->renderer = $renderer;
        $this->config = $config;
        $this->basis = $basis;
    }

    public function initialize()
    {
    }

    public function renderFirstFrame()
    {
    }

    public function renderLoopFrame()
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

    protected function numOfSnowflakesToGenerate()
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