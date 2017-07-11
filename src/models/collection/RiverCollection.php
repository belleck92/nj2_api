<?php
/**
* Created by Manu
* Date: 2017-07-11
* Time: 17:29:12
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\RiverStore;
use Fr\Nj2\Api\models\extended\River;

class RiverCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param River $river
     */
    public function ajout(River $river) {
        parent::append($river);
    }

    /**
     * Met les Rivers de la collection dans le RiverStore
     * Vérifie si le River était déjà storé, dans ce cas, remplace le River concerné par celui du RiverStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$river) {/** @var River $river */
            if(RiverStore::exists($river->getId())) $replaces[$offset] = $river;
            else RiverStore::store($river);
        }
        unset($offset);
        foreach($replaces as $offset=>$river) {
            $this->offsetSet($offset, RiverStore::getById($river->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return River
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}