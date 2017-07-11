<?php
/**
* Created by Manu
* Date: 2017-07-11
* Time: 17:29:12
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\SpyStore;
use Fr\Nj2\Api\models\extended\Spy;

class SpyCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Spy $spy
     */
    public function ajout(Spy $spy) {
        parent::append($spy);
    }

    /**
     * Met les Spys de la collection dans le SpyStore
     * Vérifie si le Spy était déjà storé, dans ce cas, remplace le Spy concerné par celui du SpyStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$spy) {/** @var Spy $spy */
            if(SpyStore::exists($spy->getId())) $replaces[$offset] = $spy;
            else SpyStore::store($spy);
        }
        unset($offset);
        foreach($replaces as $offset=>$spy) {
            $this->offsetSet($offset, SpyStore::getById($spy->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return Spy
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}