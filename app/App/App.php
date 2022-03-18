<?php declare(strict_types=1);

namespace TechBit\Snow\App;

use TechBit\Snow\Animation\Animation;
use TechBit\Snow\Animation\Scene\UserSceneProvider;
use TechBit\Snow\Animation\Wind\IWind;
use TechBit\Snow\Animation\Wind\WindComposition;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Config\PresetFactory;
use TechBit\Snow\Console\Console;
use TechBit\Snow\Console\CustomConsole;
use TechBit\Snow\Console\InvalidConsoleSizeException;
use Psr\Container\ContainerExceptionInterface;
use DI\Container;


class App
{

    public function __construct(readonly Container $container = new Container())
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws InvalidConsoleSizeException
     */
    public function configure(array $argv): void
    {
        if ($this->setupCustomScene($argv[1] ?? '')) {
            array_shift($argv);
        }

        if ($this->setupConfigPreset($argv[1] ?? '')) {
            array_shift($argv);
        }

        $this->setupConsoleSize( $argv[1] ?? '', $argv[2] ?? '');
    }

    /**
     * @throws ContainerExceptionInterface
     */
    public function playAnimation(): void
    {
        $this->container->set(IWind::class, $this->container->get(WindComposition::class));

        $animation = $this->container->get(Animation::class);
        $animation->initialize();
        $animation->play();
    }

    /**
     * @throws ContainerExceptionInterface
     */
    protected function setupCustomScene(string $argument): bool
    {
        return $this->container->get(UserSceneProvider::class)->makeFromUserArgument($argument);
    }

    /**
     * @throws ContainerExceptionInterface
     */
    private function setupConfigPreset(string $preset): bool
    {
        $config = $this->container->get(PresetFactory::class)->create($preset);
        $this->container->set(Config::class, $config);
        return $preset != '';
    }

    /**
     * @throws InvalidConsoleSizeException
     * @throws ContainerExceptionInterface
     */
    protected function setupConsoleSize(string $customWidth, string $customHeight): void
    {
        if ($customWidth > 0 && $customHeight > 0) {
            $customConsole = $this->container->get(CustomConsole::class);
            $customConsole->overrideWindow(0, (int)$customWidth, 0, (int)$customHeight);
            $this->container->set(Console::class, $customConsole);
        }

        $width = $this->container->get(Console::class)->width();
        $height = $this->container->get(Console::class)->height();

        $minWidth = $this->container->get(Config::class)->minRequiredConsoleWidth();
        $minHeight = $this->container->get(Config::class)->minRequiredConsoleHeight();

        if ($width < $minWidth || $height < $minHeight) {
            throw new InvalidConsoleSizeException("Console size must be at least ${minWidth}x${minHeight}!\n" .
                "Current console size is {$width}x{$height}.\n\nPlease make your terminal window larger!");
        }
    }

}