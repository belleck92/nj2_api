<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 16:56:53
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\PlayerStore;
use Fr\Nj2\Api\models\extended\Player;

class PlayerCollection extends BaseCollection {

    
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
     * @param mixed $index
     * @return Player
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}