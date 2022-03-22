<?php

use TechBit\Snow\App\PhpDiAppContainer;
use TechBit\Snow\App\Bootstrap;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/lib/Perlin.php';

$developerMode = getenv("PHP_SNOW_APP_MODE") === 'develop';

$app = Bootstrap::createApp(new PhpDiAppContainer());

exit(Bootstrap::run($app, $developerMode, $argv));
