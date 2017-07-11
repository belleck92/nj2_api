<?php
/**
* Created by Manu
* Date: 2017-07-10
* Time: 17:24:40
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\TypeHqStore;
use Fr\Nj2\Api\models\extended\TypeHq;

class TypeHqCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param TypeHq $typeHq
     */
    public function ajout(TypeHq $typeHq) {
        parent::append($typeHq);
    }

    /**
     * Met les TypeHqs de la collection dans le TypeHqStore
     * Vérifie si le TypeHq était déjà storé, dans ce cas, remplace le TypeHq concerné par celui du TypeHqStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$typeHq) {/** @var TypeHq $typeHq */
            if(TypeHqStore::exists($typeHq->getId())) $replaces[$offset] = $typeHq;
            else TypeHqStore::store($typeHq);
        }
        unset($offset);
        foreach($replaces as $offset=>$typeHq) {
            $this->offsetSet($offset, TypeHqStore::getById($typeHq->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return TypeHq
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}