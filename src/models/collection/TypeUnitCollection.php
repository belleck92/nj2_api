<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\TypeUnitStore;
use Fr\Nj2\Api\models\extended\TypeUnit;

class TypeUnitCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param TypeUnit $typeUnit
     */
    public function ajout(TypeUnit $typeUnit) {
        parent::append($typeUnit);
    }

    /**
     * Met les TypeUnits de la collection dans le TypeUnitStore
     * Vérifie si le TypeUnit était déjà storé, dans ce cas, remplace le TypeUnit concerné par celui du TypeUnitStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$typeUnit) {/** @var TypeUnit $typeUnit */
            if(TypeUnitStore::exists($typeUnit->getId())) $replaces[$offset] = $typeUnit;
            else TypeUnitStore::store($typeUnit);
        }
        unset($offset);
        foreach($replaces as $offset=>$typeUnit) {
            $this->offsetSet($offset, TypeUnitStore::getById($typeUnit->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return TypeUnit
     */
    public function offsetGet($index)
    {
        return parent::offsetGet($index);
    }
}