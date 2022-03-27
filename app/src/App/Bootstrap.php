<?php declare(strict_types=1);

namespace TechBit\Snow\App;

use TechBit\Snow\App;
use TechBit\Snow\App\Exception\AppUserException;
use Throwable;

final class Bootstrap
{

    public static function createApp(): IApp
    {
        return new App();
    }

    public static function createArguments(array $argv, bool $isDeveloperMode): AppArguments
    {
        return (new AppArgumentsFactory())->create($argv, $isDeveloperMode);
    }

    public static function run(IApp $app, AppArguments $appArguments): int
    {
        try {
            error_reporting($appArguments->isDeveloperMode() ? E_ALL : E_ERROR | E_PARSE);
            ini_set('display_errors', $appArguments->isDeveloperMode() ? 'On' : 'Off');

            srand(time());

            $app->run($appArguments);

            return 0;
        } catch (AppUserException $e) {
            echo PHP_EOL;
            echo $e->getMessage();
            echo PHP_EOL;
            return 1;
        } catch (Throwable $e) {
            echo $appArguments->isDeveloperMode() ? $e : 'Unknown error';
            echo PHP_EOL;
            return 1;
        }
    }

}
