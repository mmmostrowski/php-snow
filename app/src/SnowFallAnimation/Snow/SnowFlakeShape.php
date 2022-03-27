<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation\Snow;

final class SnowFlakeShape implements ISnowFlakeShape
{

    public function __construct(
        private readonly string $pressed = '#',
        private readonly array $all = ['*', '*', '*', '*', '*', "'", ".", ",", "`"],
    )
    {
    }

    public function randomShape(): string
    {
        $i = rand(0, count($this->all) - 1);
        return array_values($this->all)[$i];
    }

    public function pressedSnowSymbol(): string
    {
        return $this->pressed;
    }

}