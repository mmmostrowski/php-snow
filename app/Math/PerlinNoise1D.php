<?php

namespace TechBit\Snow\Math;


class PerlinNoise1D
{
    protected $num;

    /**
     * @var \Perlin
     */
    protected $perlin;
    /**
     * @var Interpolation
     */
    protected $interpolation;

    public function __construct(Interpolation $interpolation)
    {
        $this->perlin = new \Perlin();
        $this->interpolation = $interpolation;
    }

    public function initialize($size)
    {
        $this->perlin = new \Perlin();
        $this->perlin->_default_size = $size;
    }

    public function generate($x)
    {
        return $this->perlin->random1D($x);
    }

    public function generateInRange($x, $from, $to)
    {
        $float = $this->generate($x);
        return $this->interpolation->interpolateRatio($from, $to, $float / 2 + 0.5);
    }

}