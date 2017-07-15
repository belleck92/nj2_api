<?php
/**
* Created by Manu
* Date: 2017-07-14
* Time: 11:44:36
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\ProbaResourceClimateStore;
use Fr\Nj2\Api\models\extended\ProbaResourceClimate;
use Fr\Nj2\Api\models\business\TypeClimateBusiness;
use Fr\Nj2\Api\models\extended\TypeClimate;
use Fr\Nj2\Api\models\business\TypeResourceBusiness;
use Fr\Nj2\Api\models\extended\TypeResource;

class ProbaResourceClimateCollection extends BaseCollection {

    
    /**
     * @var TypeClimateCollection|TypeClimate[]
     */
    private $cacheTypeClimates = null;
    
    /**
     * @var TypeResourceCollection|TypeResource[]
     */
    private $cacheTypeResources = null;
    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param ProbaResourceClimate $probaResourceClimate
     */
    public function ajout(ProbaResourceClimate $probaResourceClimate) {
        parent::append($probaResourceClimate);
    }

    /**
     * Met les ProbaResourceClimates de la collection dans le ProbaResourceClimateStore
     * Vérifie si le ProbaResourceClimate était déjà storé, dans ce cas, remplace le ProbaResourceClimate concerné par celui du ProbaResourceClimateStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$probaResourceClimate) {/** @var ProbaResourceClimate $probaResourceClimate */
            if(ProbaResourceClimateStore::exists($probaResourceClimate->getId())) $replaces[$offset] = $probaResourceClimate;
            else ProbaResourceClimateStore::store($probaResourceClimate);
        }
        unset($offset);
        foreach($replaces as $offset=>$probaResourceClimate) {
            $this->offsetSet($offset, ProbaResourceClimateStore::getById($probaResourceClimate->getId()));
        }
    }
    
    /**
     * Remet à null le cache des TypeClimates liés à la collection
     */
    public function resetCacheTypeClimates() {
        $this->cacheTypeClimates = null;
    }

    /**
     * Renvoie les TypeClimates liés aux ProbaResourceClimates de cette collection
     * @return TypeClimateCollection
     */
    public function getTypeClimates(){
        if(is_null($this->cacheTypeClimates)) {
        $this->cacheTypeClimates = TypeClimateBusiness::getFromProbaResourceClimates($this);
            $this->cacheTypeClimates->store();
        }
        return $this->cacheTypeClimates;
    }
       
    /**
     * Renvoie une chaîne d'idTypeClimate de la collection
     * @return string
     */  
    public function getIdTypeClimateStr() {
        $ret = '';
        $prem = true;
        foreach($this as $probaResourceClimate) {
            if(!$prem) $ret .=',';
            $prem = false;
            $ret .= $probaResourceClimate->getIdTypeClimate();
        }
        return $ret;
    }
    
    /**
     * Remet à null le cache des TypeResources liés à la collection
     */
    public function resetCacheTypeResources() {
        $this->cacheTypeResources = null;
    }

    /**
     * Renvoie les TypeResources liés aux ProbaResourceClimates de cette collection
     * @return TypeResourceCollection
     */
    public function getTypeResources(){
        if(is_null($this->cacheTypeResources)) {
        $this->cacheTypeResources = TypeResourceBusiness::getFromProbaResourceClimates($this);
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
        foreach($this as $probaResourceClimate) {
            if(!$prem) $ret .=',';
            $prem = false;
            $ret .= $probaResourceClimate->getIdTypeResource();
        }
        return $ret;
    }
    

    /**
     * @param mixed $index
     * @return ProbaResourceClimate
     */
    public function offsetGet($index)
    {
        return parent::offsetGet($index);
    }
}