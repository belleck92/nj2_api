<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\Tech;
use Fr\Nj2\Api\models\store\TechStore;

class TechCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Tech $tech
     */
    public function ajout(Tech $tech) {
        parent::append($tech);
    }

    /**
     * Met les Techs de la collection dans le TechStore
     * Vérifie si le Tech était déjà storé, dans ce cas, remplace le Tech concerné par celui du TechStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$tech) {/** @var Tech $tech */
            if(TechStore::exists($tech->getId())) $replaces[$offset] = $tech;
            else TechStore::store($tech);
        }
        unset($offset);
        foreach($replaces as $offset=>$tech) {
            $this->offsetSet($offset, TechStore::getById($tech->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return Tech
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}