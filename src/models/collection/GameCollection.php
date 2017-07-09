<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 16:56:53
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\GameStore;
use Fr\Nj2\Api\models\extended\Game;
use Fr\Nj2\Api\models\extended\Hexa;
use Fr\Nj2\Api\models\business\HexaBusiness;

class GameCollection extends BaseCollection {

    /**
     * @var HexaCollection|Hexa[]
     */
    private $cacheHexas = null;
    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Game $game
     */
    public function ajout(Game $game) {
        parent::append($game);
    }

    /**
     * Met les Games de la collection dans le GameStore
     * Vérifie si le Game était déjà storé, dans ce cas, remplace le Game concerné par celui du GameStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$game) {/** @var Game $game */
            if(GameStore::exists($game->getId())) $replaces[$offset] = $game;
            else GameStore::store($game);
        }
        unset($offset);
        foreach($replaces as $offset=>$game) {
            $this->offsetSet($offset, GameStore::getById($game->getId()));
        }
    }
    
    /**
     * Renvoie les Hexas liés aux Games de cette collection
     * @return HexaCollection|Hexa[]
     */
    public function getHexas() {
        if(is_null($this->cacheHexas)) {
            $this->cacheHexas = HexaBusiness::getFromGames($this);
            $this->cacheHexas->store();
        }
        return $this->cacheHexas;
    }

    /**
    * Force la collection de hexas de this
    * @param HexaCollection $hexas
    */
    public function setHexas(HexaCollection $hexas)
    {
        $this->cacheHexas = $hexas;
    }

    /**
    * Remet à null le cache des hexas liés à this
    */
    public function resetCacheHexas() {
        $this->cacheHexas = null;
    }

    /**
    * Distribue les Hexas fournis en paramètre à chaque Game de la collection si le Hexa correspond.
    * @param HexaCollection $hexas
    */
    public function fillHexas(HexaCollection $hexas)
    {
        foreach($this as $game) {/** @var Game $game */
            $game->resetCacheHexas();
            $coll = new HexaCollection();
            $game->setHexas($coll);
            foreach($hexas as $hexa) {
                if($hexa->getIdGame() == $game->getIdGame()) {
                    $coll->ajout($hexa);
                }
            }
        }
    }
    

    /**
     * @param mixed $index
     * @return Game
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}