<?php


namespace TechBit\Snow\Animation\Snow;


class FlakeShapes
{

    /**
     * @var string[]
     */
    protected $all = [
        '*',
        '*',
        '*',
        '*',
        "'",
        ".",
        ",",
    ];

    protected $pressed = '#';

    /**
     * @return string[]
     */
    public function allShapes()
    {
        return $this->all;
    }

    public function randomShape()
    {
        $i = rand(0, count($this->all) - 1);
        return array_values($this->all)[$i];
    }

    public function pressedSnowSymbol()
    {
        return $this->pressed;
    }

}