<?php declare(strict_types=1);

namespace TechBit\Snow\Math;

use Perlin;


class PerlinNoise1D
{

    public function __construct(
        protected readonly Perlin $perlin)
    {
    }

    public function generate(float $x): float
    {
        return (float)$this->perlin->random1D($x);
    }

    public function generateInRange(float $x, float $from, float $to): float
    {
        return $from + ($this->generate($x) / 2 + 0.5) * ($to - $from);
    }

}