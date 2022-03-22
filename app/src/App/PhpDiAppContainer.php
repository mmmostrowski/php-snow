<?php declare(strict_types=1);

namespace TechBit\Snow\App;

use DI\Container;
use Psr\Container\ContainerExceptionInterface;
use TechBit\Snow\Animation\Animation;
use TechBit\Snow\Animation\Scene\CustomScene;
use TechBit\Snow\Animation\Scene\Scene;
use TechBit\Snow\Animation\Wind\IWind;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Config\PresetFactory;
use TechBit\Snow\Console\Console;
use TechBit\Snow\Console\CustomSizeConsole;


class PhpDiAppContainer implements IAppContainer
{

    /**
     * @param class-string<IWind> $windClass
     * @throws ContainerExceptionInterface
     */
    public function createAnimation(string $windClass, string $presetName, ?string $customScene, string $consoleSize): Animation
    {
        $container = new Container();

        $presetConfig = $container->get(PresetFactory::class)->create($presetName);
        $container->set(Config::class, $presetConfig);

        if ($customScene !== null) {
            $scene = $container->get(CustomScene::class);
            $scene->setupScene($customScene);
            $container->set(Scene::class, $scene);
        }

        if ($consoleSize != '') {
            list ($w, $h) = explode('x', $consoleSize);
            if ($w > 0 && $h > 0) {
                $customConsole = $container->get(CustomSizeConsole::class);
                $customConsole->overrideWindow(0, (int)$w, 0, (int)$h);
                $container->set(Console::class, $customConsole);
            }
        }

        $container->set(IWind::class, $container->get($windClass));

        return $container->get(Animation::class);
    }

}