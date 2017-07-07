<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\Hexa;
use Fr\Nj2\Api\models\store\HexaStore;

class HexaCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Hexa $hexa
     */
    public function ajout(Hexa $hexa) {
        parent::append($hexa);
    }

    /**
     * Met les Hexas de la collection dans le HexaStore
     * Vérifie si le Hexa était déjà storé, dans ce cas, remplace le Hexa concerné par celui du HexaStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$hexa) {/** @var Hexa $hexa */
            if(HexaStore::exists($hexa->getId())) $replaces[$offset] = $hexa;
            else HexaStore::store($hexa);
        }
        unset($offset);
        foreach($replaces as $offset=>$hexa) {
            $this->offsetSet($offset, HexaStore::getById($hexa->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return Hexa
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}