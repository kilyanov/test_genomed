<?php

use Dotenv\Dotenv as DotenvAlias;

ini_set('display_errors', getenv('DISPLAY_ERRORS'));
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);

if (file_exists(dirname(__DIR__) . '/.env.loc')) {
    $dotEnv = new DotenvAlias(dirname(__DIR__), '.env.loc');
    $dotEnv->load();
}
else {
    if (file_exists(dirname(__DIR__) . '/.env')) {
        $dotEnv = new DotenvAlias(dirname(__DIR__), '.env');
        $dotEnv->load();
    }
}

defined('YII_DEBUG') or define('YII_DEBUG', getenv('YII_DEBUG') === 'true');
defined('YII_ENV') or define('YII_ENV', getenv('YII_ENV') ?: 'prod');


