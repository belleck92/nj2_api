<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 18:24:10
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\TrajectoryHexaStore;
use Fr\Nj2\Api\models\extended\TrajectoryHexa;

class TrajectoryHexaCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param TrajectoryHexa $trajectoryHexa
     */
    public function ajout(TrajectoryHexa $trajectoryHexa) {
        parent::append($trajectoryHexa);
    }

    /**
     * Met les TrajectoryHexas de la collection dans le TrajectoryHexaStore
     * Vérifie si le TrajectoryHexa était déjà storé, dans ce cas, remplace le TrajectoryHexa concerné par celui du TrajectoryHexaStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$trajectoryHexa) {/** @var TrajectoryHexa $trajectoryHexa */
            if(TrajectoryHexaStore::exists($trajectoryHexa->getId())) $replaces[$offset] = $trajectoryHexa;
            else TrajectoryHexaStore::store($trajectoryHexa);
        }
        unset($offset);
        foreach($replaces as $offset=>$trajectoryHexa) {
            $this->offsetSet($offset, TrajectoryHexaStore::getById($trajectoryHexa->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return TrajectoryHexa
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}