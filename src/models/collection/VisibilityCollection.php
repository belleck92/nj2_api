<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\VisibilityStore;
use Fr\Nj2\Api\models\extended\Visibility;

class VisibilityCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Visibility $visibility
     */
    public function ajout(Visibility $visibility) {
        parent::append($visibility);
    }

    /**
     * Met les Visibilitys de la collection dans le VisibilityStore
     * Vérifie si le Visibility était déjà storé, dans ce cas, remplace le Visibility concerné par celui du VisibilityStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$visibility) {/** @var Visibility $visibility */
            if(VisibilityStore::exists($visibility->getId())) $replaces[$offset] = $visibility;
            else VisibilityStore::store($visibility);
        }
        unset($offset);
        foreach($replaces as $offset=>$visibility) {
            $this->offsetSet($offset, VisibilityStore::getById($visibility->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return Visibility
     */
    public function offsetGet($index)
    {
        return parent::offsetGet($index);
    }
}