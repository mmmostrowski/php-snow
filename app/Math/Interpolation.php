<?php namespace TechBit\Snow\Math;


class Interpolation
{

    public function interpolateRatio($vStart, $vStop, $scale)
    {
        return $vStart + ((float)$scale) * ($vStop - $vStart);
    }

    public function interpolateRange($vStart, $vStop, $src1, $src2, $src)
    {
        return (float)$vStart + ((float)$src / ($src2 - $src1)) * (float)($vStop - $vStart);
    }

}