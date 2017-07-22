<?php


namespace Fr\Nj2\Api\Cli;

use Fr\Nj2\Api\API;
use Fr\Nj2\Api\Config\Config;
use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Game;
use Fr\Nj2\Api\v1\Extended\Games;

if(php_sapi_name() !== 'cli') exit();

require_once(dirname(__FILE__).'/../vendor/autoload.php');

try {
    DbHandler::setConfig(Config::DB_CREDENTIALS);

    DbHandler::query('TRUNCATE game;');
    DbHandler::query('TRUNCATE hexa;');
    DbHandler::query('TRUNCATE resource;');
    DbHandler::query('TRUNCATE river;');
    DbHandler::query('TRUNCATE visibility;');
    DbHandler::query('TRUNCATE player;');

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

    API::getInstance()->setToken(['idUser'=>1]);
    $api = new Games();
    $api->create('1/players', '', [['idGame'=>1, 'name'=>'aymeric', 'color'=>'FF0']]);

    API::getInstance()->setToken(['idUser'=>2]);
    $api = new Games();
    $api->create('1/players', '', [['idGame'=>1, 'name'=>'manu', 'color'=>'F00']]);

} catch (\Throwable $e) {
    echo $e->getMessage()."\n";
    echo $e->getTraceAsString()."\n";
}
