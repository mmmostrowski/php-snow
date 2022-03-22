<?php declare(strict_types=1);

namespace TechBit\Snow\App;

interface IAppArguments
{

    public function customScene(): ?string;

    public function consoleSize(): string;

    public function presetName(): string;

}