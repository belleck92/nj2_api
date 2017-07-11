<?php


namespace Fr\Nj2\Api;

use Fr\Nj2\Api\Config\Config;
use Fr\Nj2\Api\models\DbHandler;

require_once('vendor/autoload.php');

try {
    DbHandler::setConfig(Config::DB_CREDENTIALS);
    API::getInstance()->main();
} catch (\Throwable $e) {
    echo $e->getMessage()."\n";
    echo $e->getFile().':'.$e->getLine()."\n";
    echo $e->getTraceAsString()."\n";
}

