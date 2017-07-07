<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\Trajectory;
use Fr\Nj2\Api\models\store\TrajectoryStore;

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
        parent::offsetGet($index);
    }
}