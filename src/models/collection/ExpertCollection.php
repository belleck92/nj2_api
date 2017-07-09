<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 16:56:53
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\ExpertStore;
use Fr\Nj2\Api\models\extended\Expert;

class ExpertCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Expert $expert
     */
    public function ajout(Expert $expert) {
        parent::append($expert);
    }

    /**
     * Met les Experts de la collection dans le ExpertStore
     * Vérifie si le Expert était déjà storé, dans ce cas, remplace le Expert concerné par celui du ExpertStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$expert) {/** @var Expert $expert */
            if(ExpertStore::exists($expert->getId())) $replaces[$offset] = $expert;
            else ExpertStore::store($expert);
        }
        unset($offset);
        foreach($replaces as $offset=>$expert) {
            $this->offsetSet($offset, ExpertStore::getById($expert->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return Expert
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}