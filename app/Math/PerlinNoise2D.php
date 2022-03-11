<?php

namespace TechBit\Snow\Math;


class PerlinNoise2D
{
    protected $num;

    /**
     * @var \Perlin
     */
    protected $perlin;

    public function __construct()
    {
        $this->perlin = new \Perlin();
    }

    public function initialize($size)
    {
        $this->perlin = new \Perlin();
        $this->perlin->_default_size = $size;
    }

    public function generate($x, $y)
    {
        return $this->perlin->random2D($x, $y);
    }

}