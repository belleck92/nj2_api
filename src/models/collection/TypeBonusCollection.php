<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 18:24:10
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\TypeBonusStore;
use Fr\Nj2\Api\models\extended\TypeBonus;

class TypeBonusCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param TypeBonus $typeBonus
     */
    public function ajout(TypeBonus $typeBonus) {
        parent::append($typeBonus);
    }

    /**
     * Met les TypeBonuss de la collection dans le TypeBonusStore
     * Vérifie si le TypeBonus était déjà storé, dans ce cas, remplace le TypeBonus concerné par celui du TypeBonusStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$typeBonus) {/** @var TypeBonus $typeBonus */
            if(TypeBonusStore::exists($typeBonus->getId())) $replaces[$offset] = $typeBonus;
            else TypeBonusStore::store($typeBonus);
        }
        unset($offset);
        foreach($replaces as $offset=>$typeBonus) {
            $this->offsetSet($offset, TypeBonusStore::getById($typeBonus->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return TypeBonus
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}