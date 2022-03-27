<?php declare(strict_types=1);

use TechBit\Snow\App\Bootstrap;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/lib/Perlin.php';

$app = Bootstrap::createApp();

$arguments = Bootstrap::createArguments($argv,
    isDeveloperMode: getenv("PHP_SNOW_APP_MODE") === 'develop');

exit(Bootstrap::run($app, $arguments));
