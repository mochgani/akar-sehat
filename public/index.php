<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Detect Laravel base path:
// - local dev: index.php ada di public/, Laravel root = ../
// - cPanel: index.php di-copy ke public_html/, Laravel root = ../akar-sehat/
$_basePath = is_dir(__DIR__.'/../vendor')
    ? __DIR__.'/..'
    : __DIR__.'/../akar-sehat';

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = $_basePath.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require $_basePath.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $_basePath.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
