<?php declare(strict_types=1);

namespace TechBit\Snow\Config;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerInterface;


class PresetFactory
{

    public function __construct(
        protected readonly ContainerInterface $di,
        protected readonly DefaultPresetsList $defaultPresets)
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(string $type): Config
    {
        if ($type === '' || $type == 'random') {
            return $this->createRandom();
        }

        $className = ucwords($type, '_');
        $className = str_replace('_', '', $className);
        $className = "TechBit\\Snow\\Config\\Preset\\" . $className . "Preset";

        return $this->di->get($className);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function createRandom(): Config
    {
        $presets = $this->defaultPresets->presetsList();
        $total = array_sum($presets);
        $random = rand(0, $total);
        $sum = 0;
        $chosenPreset = null;
        foreach ($presets as $presetClass => $presetWeight) {
            $sum += $presetWeight;
            if ($sum >= $random) {
                $chosenPreset = $presetClass;
                break;
            }
        }

        return $this->di->get($chosenPreset);
    }

}