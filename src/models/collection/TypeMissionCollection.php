<?php
/**
* Created by Manu
* Date: 2017-07-11
* Time: 17:29:12
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\TypeMissionStore;
use Fr\Nj2\Api\models\extended\TypeMission;

class TypeMissionCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param TypeMission $typeMission
     */
    public function ajout(TypeMission $typeMission) {
        parent::append($typeMission);
    }

    /**
     * Met les TypeMissions de la collection dans le TypeMissionStore
     * Vérifie si le TypeMission était déjà storé, dans ce cas, remplace le TypeMission concerné par celui du TypeMissionStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$typeMission) {/** @var TypeMission $typeMission */
            if(TypeMissionStore::exists($typeMission->getId())) $replaces[$offset] = $typeMission;
            else TypeMissionStore::store($typeMission);
        }
        unset($offset);
        foreach($replaces as $offset=>$typeMission) {
            $this->offsetSet($offset, TypeMissionStore::getById($typeMission->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return TypeMission
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}