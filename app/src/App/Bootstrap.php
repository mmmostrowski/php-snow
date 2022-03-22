<?php declare(strict_types=1);

namespace TechBit\Snow\App;

use TechBit\Snow\App;
use TechBit\Snow\Console\InvalidConsoleSizeException;
use Throwable;

class Bootstrap
{

    public static function createApp(IAppContainer $appContainer): App
    {
        return new App($appContainer);
    }

    public static function run(App $app, bool $isDevelopMode = false, array $argv = []): int
    {
        try {
            error_reporting($isDevelopMode ? E_ALL : E_ERROR | E_PARSE);
            ini_set('display_errors', $isDevelopMode ? 'On' : 'Off');

            srand(time());

            $animation = $app->createAnimation(new CliArguments($argv));
            $app->playAnimation($animation);

            return 0;
        } catch (InvalidConsoleSizeException $e) {
            echo PHP_EOL;
            echo $e->getMessage() . PHP_EOL;
            echo PHP_EOL;

            return 1;
        } catch (Throwable $e) {
            echo $e;
            echo PHP_EOL;

            return 1;
        }
    }

}
