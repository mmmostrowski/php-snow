<?php declare(strict_types=1);

namespace TechBit\Snow\Math;

use Perlin;


class PerlinNoise2D
{

    public function __construct(
        protected readonly Perlin $perlin)
    {
    }

    public function generate(float $x, float $y): float
    {
        return $this->perlin->random2D($x, $y);
    }

}