<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation\Config;

use LogicException;
use TechBit\Snow\App\NamedClass;


final class PresetFactory implements IPresetFactory
{

    /**
     * @param class-string<Config>[] $allConfigPresets
     * @param array<class-string<Config>, int> $defaultPresets
     */
    public function __construct(
        array   $allConfigPresets,
        private readonly array $defaultPresets,
        private readonly NamedClass $namedClass = new NamedClass("SnowFallAnimation\\Config\\Preset\\", "Preset")
    )
    {
    }

    /**
     * @param class-string<Config> $classOrName
     */
    public function create(string $classOrName, array $args = []): Config
    {
        if ($classOrName === '' || $classOrName == 'random') {
            return $this->createRandom();
        }

        $classname = $this->namedClass->toClassName($classOrName);
        return new $classname(...$args);
    }

    private function createRandom(): Config
    {
        $presets = $this->defaultPresets;
        $total = array_sum($presets);
        $random = rand(0, $total);
        $sum = 0;
        foreach ($presets as $presetClass => $presetWeight) {
            $sum += $presetWeight;
            if ($sum >= $random) {
                return $this->create($presetClass);
            }
        }
        throw new LogicException("Cannot generate random preset!");
    }

}