<?php
/**
* Created by Manu
* Date: 2017-07-14
* Time: 11:44:36
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\TrajectoryStore;
use Fr\Nj2\Api\models\extended\Trajectory;

class TrajectoryCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Trajectory $trajectory
     */
    public function ajout(Trajectory $trajectory) {
        parent::append($trajectory);
    }

    /**
     * Met les Trajectorys de la collection dans le TrajectoryStore
     * Vérifie si le Trajectory était déjà storé, dans ce cas, remplace le Trajectory concerné par celui du TrajectoryStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$trajectory) {/** @var Trajectory $trajectory */
            if(TrajectoryStore::exists($trajectory->getId())) $replaces[$offset] = $trajectory;
            else TrajectoryStore::store($trajectory);
        }
        unset($offset);
        foreach($replaces as $offset=>$trajectory) {
            $this->offsetSet($offset, TrajectoryStore::getById($trajectory->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return Trajectory
     */
    public function offsetGet($index)
    {
        return parent::offsetGet($index);
    }
}