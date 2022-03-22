<?php declare(strict_types=1);

namespace TechBit\Snow;

use Psr\Container\ContainerExceptionInterface;
use TechBit\Snow\Animation\Animation;
use TechBit\Snow\Animation\Wind\WindComposition;
use TechBit\Snow\App\IAppArguments;
use TechBit\Snow\App\IAppContainer;
use TechBit\Snow\Console\InvalidConsoleSizeException;


class App
{

    public function __construct(readonly IAppContainer $appContainer)
    {
    }

    /**
     * @throws ContainerExceptionInterface
     */
    public function createAnimation(IAppArguments $arguments): Animation
    {
        return $this->appContainer->createAnimation(
            windClass: WindComposition::class,
            presetName: $arguments->presetName(),
            customScene: $arguments->customScene(),
            consoleSize: $arguments->consoleSize(),
        );
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws InvalidConsoleSizeException
     */
    public function playAnimation(Animation $animation): void
    {
        $animation->initialize();

        $animation->play();
    }

}