<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 16:56:53
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\UnitStore;
use Fr\Nj2\Api\models\extended\Unit;

class UnitCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Unit $unit
     */
    public function ajout(Unit $unit) {
        parent::append($unit);
    }

    /**
     * Met les Units de la collection dans le UnitStore
     * Vérifie si le Unit était déjà storé, dans ce cas, remplace le Unit concerné par celui du UnitStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$unit) {/** @var Unit $unit */
            if(UnitStore::exists($unit->getId())) $replaces[$offset] = $unit;
            else UnitStore::store($unit);
        }
        unset($offset);
        foreach($replaces as $offset=>$unit) {
            $this->offsetSet($offset, UnitStore::getById($unit->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return Unit
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}