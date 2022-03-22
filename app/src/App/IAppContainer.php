<?php declare(strict_types=1);

namespace TechBit\Snow\App;

use Psr\Container\ContainerExceptionInterface;
use TechBit\Snow\Animation\Animation;
use TechBit\Snow\Animation\Wind\IWind;

interface IAppContainer
{

    /**
     * @param class-string<IWind> $windClass
     * @throws ContainerExceptionInterface
     */
    public function createAnimation(string $windClass, string $presetName, ?string $customScene, string $consoleSize): Animation;

}