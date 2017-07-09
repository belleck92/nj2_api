<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 18:24:10
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\CaravanStore;
use Fr\Nj2\Api\models\extended\Caravan;

class CaravanCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Caravan $caravan
     */
    public function ajout(Caravan $caravan) {
        parent::append($caravan);
    }

    /**
     * Met les Caravans de la collection dans le CaravanStore
     * Vérifie si le Caravan était déjà storé, dans ce cas, remplace le Caravan concerné par celui du CaravanStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$caravan) {/** @var Caravan $caravan */
            if(CaravanStore::exists($caravan->getId())) $replaces[$offset] = $caravan;
            else CaravanStore::store($caravan);
        }
        unset($offset);
        foreach($replaces as $offset=>$caravan) {
            $this->offsetSet($offset, CaravanStore::getById($caravan->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return Caravan
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}