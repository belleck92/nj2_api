<?php
/**
* Created by Manu
* Date: 2017-07-10
* Time: 17:24:40
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\TypeTreatyStore;
use Fr\Nj2\Api\models\extended\TypeTreaty;

class TypeTreatyCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param TypeTreaty $typeTreaty
     */
    public function ajout(TypeTreaty $typeTreaty) {
        parent::append($typeTreaty);
    }

    /**
     * Met les TypeTreatys de la collection dans le TypeTreatyStore
     * Vérifie si le TypeTreaty était déjà storé, dans ce cas, remplace le TypeTreaty concerné par celui du TypeTreatyStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$typeTreaty) {/** @var TypeTreaty $typeTreaty */
            if(TypeTreatyStore::exists($typeTreaty->getId())) $replaces[$offset] = $typeTreaty;
            else TypeTreatyStore::store($typeTreaty);
        }
        unset($offset);
        foreach($replaces as $offset=>$typeTreaty) {
            $this->offsetSet($offset, TypeTreatyStore::getById($typeTreaty->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return TypeTreaty
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}