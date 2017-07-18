<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 18/07/17
 * Time: 12:32
 */

namespace Fr\Nj2\Api\v1\Extended;

use Fr\Nj2\Api\API;
use Fr\Nj2\Api\models\Bean;
use Fr\Nj2\Api\models\collection\HexaCollection;
use Fr\Nj2\Api\models\extended\Game;
use Fr\Nj2\Api\models\extended\Hexa;
use Fr\Nj2\Api\models\store\GameStore;
use Fr\Nj2\Api\models\store\HexaStore;
use Fr\Nj2\Api\v1\LogicalUnit;

class Map extends LogicalUnit
{
    /**
     * @var Hexa
     */
    protected $center;

    /**
     * @var Game
     */
    protected $game;

    /**
     * @var Hexa
     */
    protected $topLeftCorner;

    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var HexaCollection
     */
    protected $hexas;

    public function getByIds($ids)
    {
        API::getInstance()->setErrorCode(5);
        API::getInstance()->setError('Unsufficient parameters');
        API::getInstance()->sendResponse(404);
    }

    public static function readableFields(Bean $bean)
    {
        API::getInstance()->sendResponse(404);
    }

    /**
     * @param string $queryString
     * @param array $parameters
     * @return array
     */
    public function get($queryString, $parameters)
    {
        if(empty(API::getInstance()->getToken()['idGame'])){
            API::getInstance()->setErrorCode(8);
            API::getInstance()->setError('Must be connected to a game');
            API::getInstance()->sendResponse(400);
        }

        if((!isset($parameters['idCenter']) || !isset($parameters['width']) || !isset($parameters['height'])) && (!isset($parameters['idCenter']) || !isset($parameters['width']) || !isset($parameters['nbSquares']))) {
            API::getInstance()->setErrorCode(6);
            API::getInstance()->setError('URL parameters must be idCenter, width, height or idCenter, width, nbSquares');
            API::getInstance()->sendResponse(400);
        }

        if((!preg_match('#^[0-9]+$#', $parameters['idCenter']) || !preg_match('#^[0-9]+$#', $parameters['width'])) || (isset($parameters['height']) && !preg_match('#^[0-9]+$#', $parameters['height']))|| (isset($parameters['nbSquares']) && !preg_match('#^[0-9]+$#', $parameters['nbSquares']))) {
            API::getInstance()->setErrorCode(7);
            API::getInstance()->setError('URL parameters must be numeric');
            API::getInstance()->sendResponse(400);
        }

        $hexa = HexaStore::getById($parameters['idCenter']);
        if(is_null($hexa)) {
            API::getInstance()->setErrorCode(10);
            API::getInstance()->setError('Unknown hexa');
            API::getInstance()->sendResponse(404);
        }

        if(API::getInstance()->getToken()['idGame'] != $hexa->getIdGame()) {
            API::getInstance()->setErrorCode(9);
            API::getInstance()->setError('Bad idGame in token');
            API::getInstance()->sendResponse(400);
        }
        $this->center = $hexa;
        $this->width = $parameters['width'];
        $this->game = GameStore::getById(API::getInstance()->getToken()['idGame']);

        if(is_null($this->game)) {
            API::getInstance()->setErrorCode(12);
            API::getInstance()->setError('Bad idGame in token');
            API::getInstance()->sendResponse(400);
        }

        if(isset($parameters['height'])) $this->height = $parameters['height'];
        else {
            if($parameters['nbSquares'] % $parameters['width']) {
                API::getInstance()->setErrorCode(11);
                API::getInstance()->setError('nbSquare must be a multiple of width');
                API::getInstance()->sendResponse(400);
            }
            $this->height = round($parameters['nbSquares'] / $parameters['width']);
        }

        $this->buildHexas();
        $resources = $this->hexas->getResources();
        foreach($resources as $res) {/** @var Resource $res */
            $res->setExtendedData(true);
        }
        $this->hexas->fillResources($resources);

        $ret = ['squares'=>Hexas::filterCollection($this->hexas)];

        return $ret;
    }


    /**
     * Renvoie les hexagones dans l'ordre d'un balayage
     * @return HexaCollection
     */
    public function buildHexas()
    {
        $this->hexas = new HexaCollection();
        $debutLigne = $this->coinSupGauche();
        for($y=1;$y<=$this->height;$y++) {
            $current = $debutLigne;
            for($x=0;$x<$this->width;$x++) {
                $current->setExtendedData(true);
                $this->hexas->ajout($current);

                // Visibles
                //$this->ajoutVisiblesHexa($current);

                $current = $current->getVoisin(0);
            }
            if(fmod($debutLigne->getY(),2) == 1) { // Y impair
                $debutLigne = $debutLigne->getVoisin(5);
            } else { // Y pair
                $debutLigne = $debutLigne->getVoisin(4);
            }
        }
    }

    /**
     * Renvoie le coin supérieur gauche de la carte
     * @return Hexa
     */
    private function coinSupGauche()
    {
        if(is_null($this->topLeftCorner)) {
            // Recalage en Y du centre pour les bords
            while ($this->center->getY() < floor($this->height / 2)) {
                if (fmod($this->center->getY(), 2) == 1) {// Y impair
                    $this->center = $this->center->getVoisin(5);
                } else {// Y pair
                    $this->center = $this->center->getVoisin(4);
                }
            }
            while (($this->game->getHauteur() - 1) - floor($this->height / 2) < $this->center->getY()) {
                if (fmod($this->center->getY(), 2) == 1) { // Y impair
                    $this->center = $this->center->getVoisin(1);
                } else { // Y pair
                    $this->center = $this->center->getVoisin(2);
                }
            }

            // Recherche Y du coin
            $coin = $this->center;
            while ($coin->getY() > $this->center->getY() - (($this->height / 2) - (1 - (fmod($this->height, 2) / 2)))) {
                if (fmod($coin->getY(), 2) == 1) { // Y impair
                    $coin = $coin->getVoisin(1);
                } else { // Y pair
                    $coin = $coin->getVoisin(2);
                }
            }

            // Recherche du X du coin
            for ($i = 1; $i <= (($this->width / 2) - (1 - (fmod($this->width, 2) / 2))); $i++) {
                $coin = $coin->getVoisin(3);
            }
            $this->topLeftCorner = $coin;
        }
        return $this->topLeftCorner;
    }

    public function update($queryString, $parameters, $queryBody)
    {
        API::getInstance()->setErrorCode(1);
        API::getInstance()->setError('Cannot update map data, use hexa api');
        API::getInstance()->sendResponse(404);
    }

    public static function getFiltered($parameters)
    {
        API::getInstance()->setErrorCode(3);
        API::getInstance()->setError('Cannot filter map data, use hexa api');
        API::getInstance()->sendResponse(404);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        API::getInstance()->setErrorCode(2);
        API::getInstance()->setError('Cannot update map data, use hexa api');
        API::getInstance()->sendResponse(404);
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        API::getInstance()->setErrorCode(4);
        API::getInstance()->setError('Cannot delete map data, use hexa api');
        API::getInstance()->sendResponse(404);
    }

}