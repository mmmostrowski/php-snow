<?php declare(strict_types=1);

namespace TechBit\Snow\App;

final class AppArgumentsFactory
{

    public function create(array $argv, bool $isDeveloperMode): AppArguments
    {
        array_shift($argv);

        $customScene = $this->isResource($argv) ? $this->readResource($argv) : null;
        $presetName = $this->read($argv);

        return new AppArguments($isDeveloperMode, [], $presetName, $customScene);
    }

    private function isResource(array $argv): bool
    {
        $value = $argv[0] ?? '';

        if (empty($value)) {
            return false;
        }

        return str_starts_with($value, 'base64:') || @file_exists($value) || @file_get_contents($value);
    }

    private function readResource(array &$argv): string
    {
        $value = $this->read($argv);

        if (str_starts_with($value, 'base64:')) {
            return (string)@base64_decode(preg_replace('/^base64:/', '', $value));
        }

        return (string)@file_get_contents($value);
    }

    private function read(array &$argv): string
    {
        if (empty($argv)) {
            return '';
        }
        return array_shift($argv);
    }
}