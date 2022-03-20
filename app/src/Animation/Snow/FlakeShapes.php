<?php declare(strict_types=1);

namespace TechBit\Snow\Animation\Snow;

class FlakeShapes
{

    protected string $pressed = '#';

    protected array $all = [
        '*',
        '*',
        '*',
        '*',
        '*',
        "'",
        ".",
        ",",
        "`",
    ];

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