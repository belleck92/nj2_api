<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 16:56:53
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\BuildingStore;
use Fr\Nj2\Api\models\extended\Building;

class BuildingCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Building $building
     */
    public function ajout(Building $building) {
        parent::append($building);
    }

    /**
     * Met les Buildings de la collection dans le BuildingStore
     * Vérifie si le Building était déjà storé, dans ce cas, remplace le Building concerné par celui du BuildingStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$building) {/** @var Building $building */
            if(BuildingStore::exists($building->getId())) $replaces[$offset] = $building;
            else BuildingStore::store($building);
        }
        unset($offset);
        foreach($replaces as $offset=>$building) {
            $this->offsetSet($offset, BuildingStore::getById($building->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return Building
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}