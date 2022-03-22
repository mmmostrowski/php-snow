<?php declare(strict_types=1);

namespace TechBit\Snow\App;

class CliArguments implements IAppArguments
{

    private readonly ?string $customScene;

    private readonly string $presetName;

    private readonly string $consoleSize;


    public function __construct(array $argv)
    {
        array_shift($argv);

        $this->customScene = $this->isResource($argv) ? $this->readResource($argv) : null;
        $this->presetName = $this->read($argv);
        $this->consoleSize = $this->read($argv);
    }

    public function customScene(): ?string
    {
        return $this->customScene;
    }

    public function consoleSize(): string
    {
        return $this->consoleSize;
    }

    public function presetName(): string
    {
        return $this->presetName;
    }

    protected function isResource(array $argv): bool
    {
        $value = $argv[0] ?? '';

        if (empty($value)) {
            return false;
        }

        return str_starts_with($value, 'base64:')
            || @file_exists($value)
            || @file_get_contents($value);
    }

    protected  function readResource(array &$argv): string
    {
        $value = $this->read($argv);

        if (str_starts_with($value, 'base64:')) {
            return (string)@base64_decode(preg_replace('/^base64:/', '', $value));
        }

        return (string)@file_get_contents($value);
    }

    protected function read(array &$argv): string
    {
        if (empty($argv)) {
            return '';
        }
        return array_shift($argv);
    }

}