<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\Bonus;
use Fr\Nj2\Api\models\store\BonusStore;

class BonusCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Bonus $bonus
     */
    public function ajout(Bonus $bonus) {
        parent::append($bonus);
    }

    /**
     * Met les Bonuss de la collection dans le BonusStore
     * Vérifie si le Bonus était déjà storé, dans ce cas, remplace le Bonus concerné par celui du BonusStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$bonus) {/** @var Bonus $bonus */
            if(BonusStore::exists($bonus->getId())) $replaces[$offset] = $bonus;
            else BonusStore::store($bonus);
        }
        unset($offset);
        foreach($replaces as $offset=>$bonus) {
            $this->offsetSet($offset, BonusStore::getById($bonus->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return Bonus
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}