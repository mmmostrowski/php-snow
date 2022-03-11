<?php

namespace TechBit\Snow\Animation\Snow;

use TechBit\Snow\Animation\Object\IAnimationAliveObject;
use TechBit\Snow\Animation\Object\IAnimationVisibleObject;
use TechBit\Snow\Animation\Renderer\Renderer;
use TechBit\Snow\Animation\Wind\BlowWind;
use TechBit\Snow\Animation\Wind\FieldWind;
use TechBit\Snow\Animation\Wind\IWind;
use TechBit\Snow\Animation\Wind\MicroWavingWind;
use TechBit\Snow\Animation\Wind\StaticWind;
use TechBit\Snow\Animation\Wind\WindComposition;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Console\Console;


class SnowAnimator implements IAnimationAliveObject, IAnimationVisibleObject
{
    /**
     * @var float
     */
    protected $gravityConstant = 0.0;
    /**
     * @var ParticlesSet
     */
    protected $particles;
    /**
     * @var SnowBasis
     */
    protected $basis;
    /**
     * @var Renderer
     */
    protected $renderer;
    /**
     * @var Console
     */
    protected $console;
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var IWind
     */
    protected $wind;

    public function __construct(
        ParticlesSet $particles, SnowBasis $basis, Renderer $renderer,
        Console      $console, Config $config, IWind $wind
    )
    {
        $this->particles = $particles;
        $this->basis = $basis;
        $this->renderer = $renderer;
        $this->console = $console;
        $this->config = $config;
        $this->wind = $wind;
    }

    public function initialize()
    {
        $this->gravityConstant = $this->config->gravity();
    }

    public function update()
    {
    }

    public function renderFirstFrame()
    {
    }

    public function renderLoopFrame()
    {
        foreach ($this->particles->all() as $idx => $data) {
            if ($this->basis->isHitAt($data[ParticlesSet::X], $data[ParticlesSet::Y])) {
                $this->basis->mergeParticle($data[ParticlesSet::X], $data[ParticlesSet::Y], $data[ParticlesSet::SHAPE]);
                $this->particles->remove($idx);
            } else {
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
    }

    public function moveParticle($idx)
    {
        // Wind
        $this->wind->moveParticle($idx);

        // Gravity
        $this->particles->moveByY($idx, $this->gravityConstant);

        // Momentum
        $this->particles->moveByMomentum($idx);
    }


}