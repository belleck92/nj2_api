<?php
/**
* Created by Manu
* Date: 2017-07-11
* Time: 17:29:12
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\HqStore;
use Fr\Nj2\Api\models\extended\Hq;

class HqCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Hq $hq
     */
    public function ajout(Hq $hq) {
        parent::append($hq);
    }

    /**
     * Met les Hqs de la collection dans le HqStore
     * Vérifie si le Hq était déjà storé, dans ce cas, remplace le Hq concerné par celui du HqStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$hq) {/** @var Hq $hq */
            if(HqStore::exists($hq->getId())) $replaces[$offset] = $hq;
            else HqStore::store($hq);
        }
        unset($offset);
        foreach($replaces as $offset=>$hq) {
            $this->offsetSet($offset, HqStore::getById($hq->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return Hq
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}