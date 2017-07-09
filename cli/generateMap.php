<?php


namespace Fr\Nj2\Api\Cli;

use Fr\Nj2\Api\Config\Config;
use Fr\Nj2\Api\mapGeneration\Game;
use Fr\Nj2\Api\models\DbHandler;

if(php_sapi_name() !== 'cli') exit();

require_once('../vendor/autoload.php');

try {
    DbHandler::setConfig(Config::DB_CREDENTIALS);

    DbHandler::query('TRUNCATE game;');
    DbHandler::query('TRUNCATE hexa;');


    $game = new Game();
    $game->setWidth(30);
    $game->setHeight(30);
    $game->setNbGermes(rand(3,5));
    $game->setAltMin(10);
    $game->setAltMax(16);
    $game->setCoefGaussMinGermes(1);
    $game->setCoefGaussMaxGermes(12);
    $game->setRandGermes(mt_rand(1,1000));
    $game->setNbGermesForet(rand(1,4));
    $game->setCoefGaussMinGermesForet(1);
    $game->setCoefGaussMaxGermesForet(12);
    $game->setRandForet(mt_rand(1,1000));
    $game->save();
    $game->genererHexas();

} catch (\Throwable $e) {
    echo $e->getMessage()."\n";
    echo $e->getTraceAsString()."\n";
}
