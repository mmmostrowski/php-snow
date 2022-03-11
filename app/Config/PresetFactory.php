<?php namespace TechBit\Snow\Config;


use TechBit\Snow\Config\Preset\SnowyPreset;
use TechBit\Snow\Config\Preset\WindyPreset;
use Psr\Container\ContainerInterface;


class PresetFactory
{

    /**
     * @var ContainerInterface
     */
    protected $di;

    /**
     * @var DefaultPresets
     */
    protected $defaultPresets;

    public function __construct(ContainerInterface $di, DefaultPresets $defaultPresets)
    {
        $this->di = $di;
        $this->defaultPresets = $defaultPresets;
    }

    /**
     * @return Config
     */
    public function provide($type)
    {
        if ($type === null) {
            return $this->di->get(Config::class);
        }

        $className = ucwords($type, '_');
        $className = str_replace('_', '', $className);
        $className = "TechBit\\Snow\\Config\\Preset\\" . $className . "Preset";

        return $this->di->get($className);
    }

    public function provideRandom()
    {
        $presets = $this->defaultPresets->presets();
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