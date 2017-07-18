<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\ParameterStore;
use Fr\Nj2\Api\models\extended\Parameter;

class ParameterCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Parameter $parameter
     */
    public function ajout(Parameter $parameter) {
        parent::append($parameter);
    }

    /**
     * Met les Parameters de la collection dans le ParameterStore
     * Vérifie si le Parameter était déjà storé, dans ce cas, remplace le Parameter concerné par celui du ParameterStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$parameter) {/** @var Parameter $parameter */
            if(ParameterStore::exists($parameter->getId())) $replaces[$offset] = $parameter;
            else ParameterStore::store($parameter);
        }
        unset($offset);
        foreach($replaces as $offset=>$parameter) {
            $this->offsetSet($offset, ParameterStore::getById($parameter->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return Parameter
     */
    public function offsetGet($index)
    {
        return parent::offsetGet($index);
    }
}