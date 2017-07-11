<?php
/**
* Created by Manu
* Date: 2017-07-10
* Time: 17:24:40
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\PalaceBonusStore;
use Fr\Nj2\Api\models\extended\PalaceBonus;

class PalaceBonusCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param PalaceBonus $palaceBonus
     */
    public function ajout(PalaceBonus $palaceBonus) {
        parent::append($palaceBonus);
    }

    /**
     * Met les PalaceBonuss de la collection dans le PalaceBonusStore
     * Vérifie si le PalaceBonus était déjà storé, dans ce cas, remplace le PalaceBonus concerné par celui du PalaceBonusStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$palaceBonus) {/** @var PalaceBonus $palaceBonus */
            if(PalaceBonusStore::exists($palaceBonus->getId())) $replaces[$offset] = $palaceBonus;
            else PalaceBonusStore::store($palaceBonus);
        }
        unset($offset);
        foreach($replaces as $offset=>$palaceBonus) {
            $this->offsetSet($offset, PalaceBonusStore::getById($palaceBonus->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return PalaceBonus
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}