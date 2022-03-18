<?php

use TechBit\Snow\App\Bootstrap;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/lib/Perlin.php';

$developerMode = file_exists(__DIR__ . '/.develop') || getenv("PHP_SNOW_APP_MODE") === 'develop';

$app = Bootstrap::createApp();

exit(Bootstrap::run($app, $developerMode, $argv));
