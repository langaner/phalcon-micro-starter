<?php

use Phalcon\Di;
use Phalcon\Mvc\Micro;
use App\Providers\AppProvider;
use App\Providers\RouteProvider;
use App\Providers\MiddlewareProvider;

/**
 * Load constants
 */
require_once __DIR__ . '/constants.php';

/**
 * Load vendors
 */
require_once BASE . '/vendor/autoload.php';

/**
 * Load config
 */
$config = require_once __DIR__ . '/configs.php';

/**
 * Debug
 */
if($config->app->debug) {
    ini_set('display_errors', 1);
    ini_set('displaystartuperrors', 1);
    error_reporting(E_ALL);
}

/**
 * Load helpers
 */
require_once __DIR__ . '/helpers.php';

/**
 * Class loader
 */
require_once __DIR__ . '/loader.php';

/**
 * Load services
 */
require_once __DIR__ . '/services.php';

/**
 * Load app services
 */
$provider = new AppProvider($container);
$provider->registerServices();

/**
 * Create application
 */
$application = new Micro($container);

/**
 * Load routes
 */
$routeProvider = new RouteProvider($application);
$application = $routeProvider->load();

/**
 * Load middleware
 */
$middlewareProvider = new MiddlewareProvider($application);
$application = $middlewareProvider->load();

return $application;