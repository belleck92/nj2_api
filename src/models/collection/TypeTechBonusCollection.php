<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 17:30:19
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\TypeTechBonusStore;
use Fr\Nj2\Api\models\extended\TypeTechBonus;

class TypeTechBonusCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param TypeTechBonus $typeTechBonus
     */
    public function ajout(TypeTechBonus $typeTechBonus) {
        parent::append($typeTechBonus);
    }

    /**
     * Met les TypeTechBonuss de la collection dans le TypeTechBonusStore
     * Vérifie si le TypeTechBonus était déjà storé, dans ce cas, remplace le TypeTechBonus concerné par celui du TypeTechBonusStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$typeTechBonus) {/** @var TypeTechBonus $typeTechBonus */
            if(TypeTechBonusStore::exists($typeTechBonus->getId())) $replaces[$offset] = $typeTechBonus;
            else TypeTechBonusStore::store($typeTechBonus);
        }
        unset($offset);
        foreach($replaces as $offset=>$typeTechBonus) {
            $this->offsetSet($offset, TypeTechBonusStore::getById($typeTechBonus->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return TypeTechBonus
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}