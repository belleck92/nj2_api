<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 16:56:53
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\TypeUnitMissionStore;
use Fr\Nj2\Api\models\extended\TypeUnitMission;

class TypeUnitMissionCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param TypeUnitMission $typeUnitMission
     */
    public function ajout(TypeUnitMission $typeUnitMission) {
        parent::append($typeUnitMission);
    }

    /**
     * Met les TypeUnitMissions de la collection dans le TypeUnitMissionStore
     * Vérifie si le TypeUnitMission était déjà storé, dans ce cas, remplace le TypeUnitMission concerné par celui du TypeUnitMissionStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$typeUnitMission) {/** @var TypeUnitMission $typeUnitMission */
            if(TypeUnitMissionStore::exists($typeUnitMission->getId())) $replaces[$offset] = $typeUnitMission;
            else TypeUnitMissionStore::store($typeUnitMission);
        }
        unset($offset);
        foreach($replaces as $offset=>$typeUnitMission) {
            $this->offsetSet($offset, TypeUnitMissionStore::getById($typeUnitMission->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return TypeUnitMission
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}