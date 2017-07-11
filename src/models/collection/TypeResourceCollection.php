<?php
/**
* Created by Manu
* Date: 2017-07-10
* Time: 17:24:40
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\TypeResourceStore;
use Fr\Nj2\Api\models\extended\TypeResource;

class TypeResourceCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param TypeResource $typeResource
     */
    public function ajout(TypeResource $typeResource) {
        parent::append($typeResource);
    }

    /**
     * Met les TypeResources de la collection dans le TypeResourceStore
     * Vérifie si le TypeResource était déjà storé, dans ce cas, remplace le TypeResource concerné par celui du TypeResourceStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$typeResource) {/** @var TypeResource $typeResource */
            if(TypeResourceStore::exists($typeResource->getId())) $replaces[$offset] = $typeResource;
            else TypeResourceStore::store($typeResource);
        }
        unset($offset);
        foreach($replaces as $offset=>$typeResource) {
            $this->offsetSet($offset, TypeResourceStore::getById($typeResource->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return TypeResource
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}