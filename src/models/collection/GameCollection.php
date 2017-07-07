<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\Game;
use Fr\Nj2\Api\models\store\GameStore;

class GameCollection extends BaseCollection {

    
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
     * @param mixed $index
     * @return Game
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}