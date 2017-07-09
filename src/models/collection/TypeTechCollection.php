<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 18:24:10
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\TypeTechStore;
use Fr\Nj2\Api\models\extended\TypeTech;

class TypeTechCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param TypeTech $typeTech
     */
    public function ajout(TypeTech $typeTech) {
        parent::append($typeTech);
    }

    /**
     * Met les TypeTechs de la collection dans le TypeTechStore
     * Vérifie si le TypeTech était déjà storé, dans ce cas, remplace le TypeTech concerné par celui du TypeTechStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$typeTech) {/** @var TypeTech $typeTech */
            if(TypeTechStore::exists($typeTech->getId())) $replaces[$offset] = $typeTech;
            else TypeTechStore::store($typeTech);
        }
        unset($offset);
        foreach($replaces as $offset=>$typeTech) {
            $this->offsetSet($offset, TypeTechStore::getById($typeTech->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return TypeTech
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}