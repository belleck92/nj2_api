<?php
/**
* Created by Manu
* Date: 2017-07-10
* Time: 17:24:40
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\AllianceStore;
use Fr\Nj2\Api\models\extended\Alliance;

class AllianceCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Alliance $alliance
     */
    public function ajout(Alliance $alliance) {
        parent::append($alliance);
    }

    /**
     * Met les Alliances de la collection dans le AllianceStore
     * Vérifie si le Alliance était déjà storé, dans ce cas, remplace le Alliance concerné par celui du AllianceStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$alliance) {/** @var Alliance $alliance */
            if(AllianceStore::exists($alliance->getId())) $replaces[$offset] = $alliance;
            else AllianceStore::store($alliance);
        }
        unset($offset);
        foreach($replaces as $offset=>$alliance) {
            $this->offsetSet($offset, AllianceStore::getById($alliance->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return Alliance
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}