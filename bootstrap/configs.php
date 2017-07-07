<?php

use \Phalcon\Config;

/**
 * Load configuration files
 */
$database = require_once BASE . '/config/database.php';
$app = require_once BASE . '/config/app.php';
$cli = require_once BASE . '/config/cli.php';
$mail = require_once BASE . '/config/mail.php';
$file = require_once BASE . '/config/file.php';
$cache = require_once BASE . '/config/cache.php';
$auth = require_once BASE . '/config/auth.php';

return new Config([
	'database' => $database,
	'app' => $app,
	'cli' => $cli,
	'module' => $module,
	'mail' => $mail,
	'file' => $file,
	'cache' => $cache,
	'auth' => $auth
]);
