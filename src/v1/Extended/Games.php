<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 */

namespace Fr\Nj2\Api\v1\Extended;

use Fr\Nj2\Api\API;
use Fr\Nj2\Api\models\business\TypeClimateBusiness;
use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Hexa;
use Fr\Nj2\Api\models\extended\Parameter;
use Fr\Nj2\Api\models\extended\TypeClimate;
use Fr\Nj2\Api\models\store\GameStore;
use Fr\Nj2\Api\models\store\UserStore;

class Games extends \Fr\Nj2\Api\v1\LogicalUnits\Games
{
    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if (preg_match('#^[0-9]+$#', $segments[0])) {
            if($segments[1] == "players") {
                if(!isset($queryBody[0])) {
                    API::getInstance()->setErrorCode(1);
                    API::getInstance()->setError('No player object');
                    API::getInstance()->sendResponse(400);
                }
                if(!isset($queryBody[0]['idGame']) || !isset($queryBody[0]['name']) || !isset($queryBody[0]['color'])) {
                    API::getInstance()->setErrorCode(2);
                    API::getInstance()->setError('idGame,  name and color fields are mandatory');
                    API::getInstance()->sendResponse(400);
                }

                $game = GameStore::getById($queryBody[0]['idGame']);
                if(is_null($game)) {
                    API::getInstance()->setErrorCode(3);
                    API::getInstance()->setError('Game '.$queryBody[0]['idGame'].' does not exist');
                    API::getInstance()->sendResponse(400);
                }
                $user = UserStore::getById(API::getInstance()->getToken()['idUser']);
                if($user->hasPlayerOn($game)){
                    API::getInstance()->setErrorCode(4);
                    API::getInstance()->setError('User has already a player on game '.$queryBody[0]['idGame']);
                    API::getInstance()->sendResponse(400);
                }

                /*
                 * Search of a free hexa
                 */
                $climates = TypeClimateBusiness::getAll();
                $climates->store();
                $game->getHexas()->store();
                $req = "SELECT * FROM hexa WHERE idTerritory = 0 AND idTypeClimate IN (
                  ".TypeClimate::getByFctId(TypeClimate::TYPE_HILL)->getId()."
                  ,".TypeClimate::getByFctId(TypeClimate::TYPE_FOREST)->getId()."
                  ,".TypeClimate::getByFctId(TypeClimate::TYPE_PLAIN)->getId()."
                  ,".TypeClimate::getByFctId(TypeClimate::TYPE_MEADOW)->getId()."
                ) UNION SELECT distinct hexa.* FROM hexa LEFT OUTER JOIN river on hexa.idHexa=river.idHexa WHERE idTerritory = 0 AND idTypeClimate = ".TypeClimate::getByFctId(TypeClimate::TYPE_DESERT)->getId()."
                ORDER BY Rand();";
                $hexas = DbHandler::collFromQuery($req,'Hexa', 'HexaCollection');

                if($hexas->count() == 0) {
                    API::getInstance()->setErrorCode(5);
                    API::getInstance()->setError('There is no more free hexas on game '.$queryBody[0]['idGame']);
                    API::getInstance()->sendResponse(400);
                }

                $selectedHexa = null;
                foreach ($hexas as $hexa) {/** @var Hexa $hexa*/
                    foreach ($hexa->getCouronnePleine(Parameter::val(Parameter::CITY_RADIUS)) as $h) {
                        if($h->getIdTerritory() != 0) continue;
                    }
                    $selectedHexa = $hexa;
                }

                if(is_null($selectedHexa)){
                    API::getInstance()->setErrorCode(5);
                    API::getInstance()->setError('There is no more free hexas on game '.$queryBody[0]['idGame']);
                    API::getInstance()->sendResponse(400);
                }

                /*
                 * Creation of player object
                 */
                $player = $game->createPlayer();
                $player->setIdUser(API::getInstance()->getToken()['idUser']);
                $player->setName($queryBody[0]['name']);
                $player->setColor($queryBody[0]['color']);
                $player->setTreasure(Parameter::val(Parameter::BEGINNING_TREASURY));
                $player->setTaxRate(Parameter::val(Parameter::BEGINNING_TAX_RATE));
                $player->setCapitalCity($selectedHexa->getId());
                $player->save();

                /*
                 * Creation of capital city
                 */
                $selectedHexa->setIdPlayer($player->getId());
                $selectedHexa->setPopulation(Parameter::val(Parameter::CAPITAL_POP));
                foreach ($selectedHexa->getCouronnePleine(Parameter::val(Parameter::CITY_RADIUS)) as $h) {
                    $h->setIdTerritory($player->getId());
                    $h->save();
                }
                return $player->getAsArray();
            }
        }
        return parent::create($queryString, $parameters, $queryBody);
    }
}