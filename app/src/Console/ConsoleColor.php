<?php declare(strict_types=1);

namespace TechBit\Snow\Console;


enum ConsoleColor
{
    case DEFAULT;

    case BLUE;
    case LIGHT_BLUE;
    case GREEN;

    public function terminalCode(): string
    {
        return match($this)
        {
            self::DEFAULT => "\e[0m",
            self::BLUE => "\e[34m",
            self::LIGHT_BLUE => "\e[94m",
            self::GREEN => "\e[32m",
        };
    }
}
