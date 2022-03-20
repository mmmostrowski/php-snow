<?php

use DI\Container;
use TechBit\Snow\App\Bootstrap;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/lib/Perlin.php';

$developerMode = getenv("PHP_SNOW_APP_MODE") === 'develop';

$app = Bootstrap::createApp(new Container());

exit(Bootstrap::run($app, $developerMode, $argv));
