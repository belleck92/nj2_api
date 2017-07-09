<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 16:56:53
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\TypeBuildingStore;
use Fr\Nj2\Api\models\extended\TypeBuilding;

class TypeBuildingCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param TypeBuilding $typeBuilding
     */
    public function ajout(TypeBuilding $typeBuilding) {
        parent::append($typeBuilding);
    }

    /**
     * Met les TypeBuildings de la collection dans le TypeBuildingStore
     * Vérifie si le TypeBuilding était déjà storé, dans ce cas, remplace le TypeBuilding concerné par celui du TypeBuildingStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$typeBuilding) {/** @var TypeBuilding $typeBuilding */
            if(TypeBuildingStore::exists($typeBuilding->getId())) $replaces[$offset] = $typeBuilding;
            else TypeBuildingStore::store($typeBuilding);
        }
        unset($offset);
        foreach($replaces as $offset=>$typeBuilding) {
            $this->offsetSet($offset, TypeBuildingStore::getById($typeBuilding->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return TypeBuilding
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}