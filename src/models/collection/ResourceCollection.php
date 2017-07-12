<?php
/**
* Created by Manu
* Date: 2017-07-12
* Time: 12:12:19
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\ResourceStore;
use Fr\Nj2\Api\models\extended\Resource;
use Fr\Nj2\Api\models\business\TypeResourceBusiness;
use Fr\Nj2\Api\models\extended\TypeResource;
use Fr\Nj2\Api\models\business\HexaBusiness;
use Fr\Nj2\Api\models\extended\Hexa;

class ResourceCollection extends BaseCollection {

    
    /**
     * @var TypeResourceCollection|TypeResource[]
     */
    private $cacheTypeResources = null;
    
    /**
     * @var HexaCollection|Hexa[]
     */
    private $cacheHexas = null;
    
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
     * Remet à null le cache des TypeResources liés à la collection
     */
    public function resetCacheTypeResources() {
        $this->cacheTypeResources = null;
    }

    /**
     * Renvoie les TypeResources liés aux Resources de cette collection
     * @return TypeResourceCollection
     */
    public function getTypeResources(){
        if(is_null($this->cacheTypeResources)) {
        $this->cacheTypeResources = TypeResourceBusiness::getFromResources($this);
            $this->cacheTypeResources->store();
        }
        return $this->cacheTypeResources;
    }
       
    /**
     * Renvoie une chaîne d'idTypeResource de la collection
     * @return string
     */  
    public function getIdTypeResourceStr() {
        $ret = '';
        $prem = true;
        foreach($this as $resource) {
            if(!$prem) $ret .=',';
            $prem = false;
            $ret .= $resource->getIdTypeResource();
        }
        return $ret;
    }
    
    /**
     * Remet à null le cache des Hexas liés à la collection
     */
    public function resetCacheHexas() {
        $this->cacheHexas = null;
    }

    /**
     * Renvoie les Hexas liés aux Resources de cette collection
     * @return HexaCollection
     */
    public function getHexas(){
        if(is_null($this->cacheHexas)) {
        $this->cacheHexas = HexaBusiness::getFromResources($this);
            $this->cacheHexas->store();
        }
        return $this->cacheHexas;
    }
       
    /**
     * Renvoie une chaîne d'idHexa de la collection
     * @return string
     */  
    public function getIdHexaStr() {
        $ret = '';
        $prem = true;
        foreach($this as $resource) {
            if(!$prem) $ret .=',';
            $prem = false;
            $ret .= $resource->getIdHexa();
        }
        return $ret;
    }
    

    /**
     * @param mixed $index
     * @return Resource
     */
    public function offsetGet($index)
    {
        return parent::offsetGet($index);
    }
}