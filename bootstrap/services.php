<?php

use Phalcon\DI\FactoryDefault;
use Phalcon\DI;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Http\Response\Cookies;
use Phalcon\Cache\Backend\Memcache;
use Phalcon\Cache\Backend\File;
use Phalcon\Cache\Backend\Redis;
use Phalcon\Cache\Backend\Apc;
use Phalcon\Cache\Frontend\Data as FrontData;

/**
 * Create a new Factory default dependancy injector
 */
$container = new FactoryDefault;

/**
 * Start the session
 */
$container->set('session', function() {
    $session = new SessionAdapter();
    $session->start();
    return $session;
});

/**
 * Load cookies
 */
$container->set('cookies', function() {
    $cookies = new Cookies();
    $cookies->useEncryption(false);

    return $cookies;
});

/**
 * The database service
 */
$container->set('db', function() use ($config) {
	return new DbAdapter($config->database->connections[$config->database->default]);
});

/**
 * Cache service
 */
$container->set('cache', function() use ($config) {
	$cache = '';
	
	switch ($config->cache->default) {
		case 'file':
			$frontCache = new FrontData([
				"lifetime" => $config->cache->file->lifetime,
			]);

			$backendOptions = [
				"cacheDir" => $config->cache->file->cacheDir,
			];

			$cache = new File($frontCache, $backendOptions);
			break;
		case 'memcached':
			$frontCache = new FrontData([
				"lifetime" => $config->cache->memcached->lifetime,
			]);

			$cache = new Memcache(
				$frontCache,
				[
					"host" => $config->cache->memcached->host,
					"port" => $config->cache->memcached->port,
					"persistent" => $config->cache->memcached->persistent,
				]
			);
			break;
		case 'redis':
			$frontCache = new FrontData([
				"lifetime" => $config->cache->redis->lifetime,
			]);

			$cache = new Redis(
				$frontCache,
				[
					"host" => $config->cache->redis->host,
					"port" => $config->cache->redis->port,
					"auth" => $config->cache->redis->auth,
					"persistent" => $config->cache->redis->persistent,
					"index" => $config->cache->redis->index,
				]
			);
			break;
		case 'apc':
			$frontCache = new FrontData([
				"lifetime" => $config->cache->apc->lifetime,
			]);

			$cache = new Apc(
				$frontCache,
				[
					"prefix" => $config->cache->apc->prefix,
				]
			);
			break;
	}

	return $cache;
});

/**
 * The Views service
 */
$container->set('view', function() use ($config) {
	$view = new View;

	$view->setViewsDir($config->app->viewsDir);

	$view->registerEngines([
		'.volt'	=> function($view, $container) use ($config) {
			$volt = new VoltEngine($view, $container);

			$volt->setOptions([
				'compiledPath'		=> $config->app->cacheDir,
				'compiledSeperator'	=> '_'
			]);

			return $volt;
		},
			'.phtml' => 'Phalcon\Mvc\View\Engine\Php'
		]);

	return $view;
}, true);

/**
 * Models manager
 */
$container->set('modelsManager', function() {
    return new Manager();
});

/**
 * Dispatcher
 */
$container->set('dispatcher', function() {
    return new Dispatcher();
});

/**
 * Load the url resolver
 */
$container->set('url', function() use ($config) {
	$url = new UrlResolver;
	$url->setBaseUri($config->app->baseUrl);

	return $url;
}, true);

/**
 * Load config
 */
$container->set('config', function () use($config) {
    return $config;
});

/**
 * Load logger
 */
$container->set("logger", function () use ($config, $container) {
	$router = $container->get('router');
	$controller = $router->getControllerName();
	$action = $router->getActionName();
	$logger = new FileAdapter($config->app->logsPath);
	$formatter = new LineFormatter("[%date%][Controller: ".$controller."->Action: ".$action."][%type%]{%message%}");
	$logger->setFormatter($formatter);
	return $logger;
});

DI::setDefault($container);

return $container;