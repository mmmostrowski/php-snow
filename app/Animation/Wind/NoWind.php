<?php declare(strict_types=1);

namespace TechBit\Snow\Animation\Wind;


class NoWind implements IWind
{

    public function moveParticle(int $idx): void
    {
    }

}