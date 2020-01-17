<?php

define('BASE_DIR', '/fw');
define('ROOT_DIR', realpath('.') . '/');
define('SYSTEM_DIR', ROOT_DIR . 'system/');
define('APP_DIR', ROOT_DIR . 'application/');
define('SERVER_NAME', $_SERVER['SERVER_NAME']);
define('SERVER_PORT', $_SERVER['SERVER_PORT']);
if(BASE_DIR != '/') {
	define('ROOT_URL', 'http://'. SERVER_NAME . ':' . SERVER_PORT . BASE_DIR . '/');
}
else {
	define('ROOT_URL', 'http://'. SERVER_NAME . ':' . SERVER_PORT . '/');
}
define('APP_URL', ROOT_URL . 'application/');
define('SYSTEM_URL', ROOT_URL . 'system/');
define('DIRECT', true);


require SYSTEM_DIR . 'core/Config.php';
require SYSTEM_DIR . 'core/Bootstrap.php';
require SYSTEM_DIR . 'core/Controller.php';
require SYSTEM_DIR . 'core/Model.php';

$app = new Bootstrap();
