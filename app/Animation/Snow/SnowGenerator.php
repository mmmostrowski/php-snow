<?php


namespace TechBit\Snow\Animation\Snow;

use TechBit\Snow\Animation\Object\IAnimationObject;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Console\Console;


class SnowGenerator implements IAnimationObject
{

    /**
     * @var bool
     */
    protected $debug = false;

    /**
     * @var
     */
    protected $howMuchSnowIsGeneratedAtTop;

    /**
     * @var Config
     */
    protected $config;
    /**
     * @var Console
     */
    protected $console;
    /**
     * @var FlakeShapes
     */
    protected $shapes;

    public function __construct(Config $config, Console $console, FlakeShapes $shapes)
    {
        $this->config = $config;
        $this->console = $console;
        $this->shapes = $shapes;
    }

    public function initialize()
    {
        $this->howMuchSnowIsGeneratedAtTop = $this->config->snowProbabilityOfProducingFromTop();
    }

    public function generateFlakeParticle()
    {
        $shape = $this->shapes->randomShape();

        if (rand(0, 100) <= $this->howMuchSnowIsGeneratedAtTop) {
            return $this->randomAtTop($shape);
        }
        return $this->randomInCenterArea($shape);
    }

    protected function randomAtTop($shape)
    {
        $w2 = (int)($this->console->width() / 2);
        return [
                ParticlesSet::X => rand($this->console->minX() - $w2, $this->console->maxX() + $w2),
                ParticlesSet::Y => $this->console->minY(),
                ParticlesSet::SHAPE => $shape,
            ] + $this->particleDefaults();
    }

    protected function randomInCenterArea($shape)
    {
        return [
                ParticlesSet::X => rand($this->console->minX(), $this->console->maxX()),
                ParticlesSet::Y => rand($this->console->minY(), $this->console->maxY()),
                ParticlesSet::SHAPE => $shape,
            ] + $this->particleDefaults();
    }

    protected function particleDefaults()
    {
        return [
            ParticlesSet::X => -1,
            ParticlesSet::Y => -1,
            ParticlesSet::SHAPE => '',
            ParticlesSet::MOMENTUM_X => 0.0,
            ParticlesSet::MOMENTUM_Y => 0.0,
        ];
    }

}