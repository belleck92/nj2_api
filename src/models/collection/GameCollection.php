<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\GameStore;
use Fr\Nj2\Api\models\extended\Game;
use Fr\Nj2\Api\models\extended\Hexa;
use Fr\Nj2\Api\models\business\HexaBusiness;
use Fr\Nj2\Api\models\extended\Player;
use Fr\Nj2\Api\models\business\PlayerBusiness;

class GameCollection extends BaseCollection {

    /**
     * @var HexaCollection|Hexa[]
     */
    private $cacheHexas = null;
    /**
     * @var PlayerCollection|Player[]
     */
    private $cachePlayers = null;
    
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
     * @return HexaCollection
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
            foreach($hexas as $hexa) {/** @var Hexa $hexa */
                if($hexa->getIdGame() == $game->getIdGame()) {
                    $coll->ajout($hexa);
                }
            }
        }
    }
    
    /**
     * Renvoie les Players liés aux Games de cette collection
     * @return PlayerCollection
     */
    public function getPlayers() {
        if(is_null($this->cachePlayers)) {
            $this->cachePlayers = PlayerBusiness::getFromGames($this);
            $this->cachePlayers->store();
        }
        return $this->cachePlayers;
    }

    /**
    * Force la collection de players de this
    * @param PlayerCollection $players
    */
    public function setPlayers(PlayerCollection $players)
    {
        $this->cachePlayers = $players;
    }

    /**
    * Remet à null le cache des players liés à this
    */
    public function resetCachePlayers() {
        $this->cachePlayers = null;
    }

    /**
    * Distribue les Players fournis en paramètre à chaque Game de la collection si le Player correspond.
    * @param PlayerCollection $players
    */
    public function fillPlayers(PlayerCollection $players)
    {
        foreach($this as $game) {/** @var Game $game */
            $game->resetCachePlayers();
            $coll = new PlayerCollection();
            $game->setPlayers($coll);
            foreach($players as $player) {/** @var Player $player */
                if($player->getIdGame() == $game->getIdGame()) {
                    $coll->ajout($player);
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
        return parent::offsetGet($index);
    }
}