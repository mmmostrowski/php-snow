<?php declare(strict_types=1);

namespace TechBit\Snow\Animation\Wind;


interface IWind
{

    public function moveParticle(int $idx): void;

}