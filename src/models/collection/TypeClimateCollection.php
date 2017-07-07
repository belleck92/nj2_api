<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\TypeClimate;
use Fr\Nj2\Api\models\store\TypeClimateStore;

class TypeClimateCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param TypeClimate $typeClimate
     */
    public function ajout(TypeClimate $typeClimate) {
        parent::append($typeClimate);
    }

    /**
     * Met les TypeClimates de la collection dans le TypeClimateStore
     * Vérifie si le TypeClimate était déjà storé, dans ce cas, remplace le TypeClimate concerné par celui du TypeClimateStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$typeClimate) {/** @var TypeClimate $typeClimate */
            if(TypeClimateStore::exists($typeClimate->getId())) $replaces[$offset] = $typeClimate;
            else TypeClimateStore::store($typeClimate);
        }
        unset($offset);
        foreach($replaces as $offset=>$typeClimate) {
            $this->offsetSet($offset, TypeClimateStore::getById($typeClimate->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return TypeClimate
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}