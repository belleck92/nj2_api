<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 17:30:19
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\ResourceStore;
use Fr\Nj2\Api\models\extended\Resource;

class ResourceCollection extends BaseCollection {

    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Resource $resource
     */
    public function ajout(Resource $resource) {
        parent::append($resource);
    }

    /**
     * Met les Resources de la collection dans le ResourceStore
     * Vérifie si le Resource était déjà storé, dans ce cas, remplace le Resource concerné par celui du ResourceStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$resource) {/** @var Resource $resource */
            if(ResourceStore::exists($resource->getId())) $replaces[$offset] = $resource;
            else ResourceStore::store($resource);
        }
        unset($offset);
        foreach($replaces as $offset=>$resource) {
            $this->offsetSet($offset, ResourceStore::getById($resource->getId()));
        }
    }
    

    /**
     * @param mixed $index
     * @return Resource
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}