<?php
/**
* Created by Manu
* Date: 2017-07-12
* Time: 11:03:33
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\TreatyStore;
use Fr\Nj2\Api\models\extended\Treaty;

class TreatyCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Treaty $treaty
     */
    public function ajout(Treaty $treaty) {
        parent::append($treaty);
    }

    /**
     * Met les Treatys de la collection dans le TreatyStore
     * Vérifie si le Treaty était déjà storé, dans ce cas, remplace le Treaty concerné par celui du TreatyStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$treaty) {/** @var Treaty $treaty */
            if(TreatyStore::exists($treaty->getId())) $replaces[$offset] = $treaty;
            else TreatyStore::store($treaty);
        }
        unset($offset);
        foreach($replaces as $offset=>$treaty) {
            $this->offsetSet($offset, TreatyStore::getById($treaty->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return Treaty
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}