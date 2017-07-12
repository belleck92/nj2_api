<?php
/**
* Created by Manu
* Date: 2017-07-12
* Time: 11:03:33
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\TypeResourceBonusStore;
use Fr\Nj2\Api\models\extended\TypeResourceBonus;

class TypeResourceBonusCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param TypeResourceBonus $typeResourceBonus
     */
    public function ajout(TypeResourceBonus $typeResourceBonus) {
        parent::append($typeResourceBonus);
    }

    /**
     * Met les TypeResourceBonuss de la collection dans le TypeResourceBonusStore
     * Vérifie si le TypeResourceBonus était déjà storé, dans ce cas, remplace le TypeResourceBonus concerné par celui du TypeResourceBonusStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$typeResourceBonus) {/** @var TypeResourceBonus $typeResourceBonus */
            if(TypeResourceBonusStore::exists($typeResourceBonus->getId())) $replaces[$offset] = $typeResourceBonus;
            else TypeResourceBonusStore::store($typeResourceBonus);
        }
        unset($offset);
        foreach($replaces as $offset=>$typeResourceBonus) {
            $this->offsetSet($offset, TypeResourceBonusStore::getById($typeResourceBonus->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return TypeResourceBonus
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}