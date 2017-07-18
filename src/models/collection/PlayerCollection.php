<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\PlayerStore;
use Fr\Nj2\Api\models\extended\Player;
use Fr\Nj2\Api\models\business\GameBusiness;
use Fr\Nj2\Api\models\extended\Game;

class PlayerCollection extends BaseCollection {

    
    /**
     * @var GameCollection|Game[]
     */
    private $cacheGames = null;
    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Player $player
     */
    public function ajout(Player $player) {
        parent::append($player);
    }

    /**
     * Met les Players de la collection dans le PlayerStore
     * Vérifie si le Player était déjà storé, dans ce cas, remplace le Player concerné par celui du PlayerStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$player) {/** @var Player $player */
            if(PlayerStore::exists($player->getId())) $replaces[$offset] = $player;
            else PlayerStore::store($player);
        }
        unset($offset);
        foreach($replaces as $offset=>$player) {
            $this->offsetSet($offset, PlayerStore::getById($player->getId()));
        }
    }
    
    /**
     * Remet à null le cache des Games liés à la collection
     */
    public function resetCacheGames() {
        $this->cacheGames = null;
    }

    /**
     * Renvoie les Games liés aux Players de cette collection
     * @return GameCollection
     */
    public function getGames(){
        if(is_null($this->cacheGames)) {
        $this->cacheGames = GameBusiness::getFromPlayers($this);
            $this->cacheGames->store();
        }
        return $this->cacheGames;
    }
       
    /**
     * Renvoie une chaîne d'idGame de la collection
     * @return string
     */  
    public function getIdGameStr() {
        $ret = '';
        $prem = true;
        foreach($this as $player) {
            if(!$prem) $ret .=',';
            $prem = false;
            $ret .= $player->getIdGame();
        }
        return $ret;
    }
    

    /**
     * @param mixed $index
     * @return Player
     */
    public function offsetGet($index)
    {
        return parent::offsetGet($index);
    }
}