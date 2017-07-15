<?php


namespace Fr\Nj2\Api;

use Fr\Nj2\Api\Config\Config;
use Fr\Nj2\Api\models\DbHandler;

require_once('vendor/autoload.php');

try {
    DbHandler::setConfig(Config::DB_CREDENTIALS);

    header('Access-Control-Allow-Origin: http://nj2.gruik.fr');
    header('Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
    API::getInstance()->main();
} catch (\Throwable $e) {
    echo $e->getMessage()."\n";
    echo $e->getFile().':'.$e->getLine()."\n";
    echo $e->getTraceAsString()."\n";
}

