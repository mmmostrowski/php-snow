<?php

if ( getenv("PHP_SNOW_APP_MODE") == 'develop' ) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
} else {
    error_reporting(E_ERROR | E_PARSE);
    ini_set('display_errors','Off');
}

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/lib/Perlin.php';

exit( \TechBit\Snow\App::run($argv) );

