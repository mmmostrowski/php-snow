<?php namespace TechBit\Snow;

use TechBit\Snow\Animation\Animation;
use TechBit\Snow\Animation\Scene\UserSceneProvider;
use TechBit\Snow\Animation\Wind\BlowWind;
use TechBit\Snow\Animation\Wind\FieldWind;
use TechBit\Snow\Animation\Wind\IWind;
use TechBit\Snow\Animation\Wind\MicroWavingWind;
use TechBit\Snow\Animation\Wind\NoWind;
use TechBit\Snow\Animation\Wind\StaticWind;
use TechBit\Snow\Animation\Wind\WindComposition;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Config\PresetFactory;
use TechBit\Snow\Console\Console;
use TechBit\Snow\Console\CustomConsole;
use DI\Container;
use Magento\Config\Model\Config\Backend\Admin\Custom;
use Magento\Framework\Profiler\Driver\Standard\Stat;
use TechBit\Snow\Console\InvalidConsoleSizeException;


class App
{

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Animation
     */
    protected $animation;

    /**
     * @var UserSceneProvider
     */
    protected $customScene;

    public static function run(array $argv)
    {
        try {
            $app = new App();
            $app->initialize($argv);
            return $app->execute();
        } catch (InvalidConsoleSizeException $e) {
            echo PHP_EOL;
            echo $e->getMessage() . PHP_EOL;
            echo PHP_EOL;
            return 1;
        } catch (\Exception $e) {
            echo $e;
            echo PHP_EOL;
            return 1;
        }
    }

    public function __construct()
    {
        $this->container = new Container();
    }

    protected function initialize(array $argv)
    {
        srand(time());

        $customSceneContent = $this->determineCustomSceneContent($argv[1]);
        if ($customSceneContent) {
            array_shift($argv);
        }

        if (isset($argv[1]) && $argv[1] != 'random') {
            $config = $this->presetFactory()->provide($argv[1]);
        } else {
            $config = $this->presetFactory()->provideRandom();
        }

        if (isset($argv[2]) && isset($argv[3])) {
            $customConsole = $this->customConsole();
            $customConsole->overrideWindow(0, $argv[2], 0, $argv[3]);
            $this->container->set(Console::class, $customConsole);
        }

        $this->ensureConsoleLargeEnough(
            $config->minRequiredConsoleWidth(),
            $config->minRequiredConsoleHeight()
        );

        $this->container->set(Config::class, $config);
        $this->container->set(IWind::class, $this->container->get(WindComposition::class));

        $this->setupCustomScene($this->container->get(UserSceneProvider::class), $customSceneContent);

        $this->animation = $this->container->get(Animation::class);
        $this->animation->initialize();
    }

    protected function setupCustomScene(UserSceneProvider $sceneProvider, $customSceneContent)
    {
        if (!$customSceneContent) {
            return;
        }
        $sceneProvider->makeCustomScene($customSceneContent);
    }

    protected function execute()
    {
        $this->animation->play();
    }

    /**
     * @return PresetFactory
     */
    protected function presetFactory()
    {
        return $this->container->get(PresetFactory::class);
    }

    /**
     * @return CustomConsole
     */
    protected function customConsole()
    {
        return $this->container->get(CustomConsole::class);
    }

    /**
     * @param $minWidth
     * @param $minHeight
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    protected function ensureConsoleLargeEnough($minWidth, $minHeight)
    {
        $width = $this->container->get(Console::class)->width();
        $height = $this->container->get(Console::class)->height();

        if ($width < $minWidth || $height < $minHeight) {
            throw new InvalidConsoleSizeException("Console size must be at least ${minWidth}x${minHeight}!\nCurrent console size is {$width}x{$height}.\nPlease make your terminal window larger!");
        }
    }

    protected function determineCustomSceneContent($arg)
    {
        $customSceneContent = false;
        if (!empty($arg) ) {
            $customSceneContent = @file_get_contents($arg);
        }
        return $customSceneContent;
    }
}