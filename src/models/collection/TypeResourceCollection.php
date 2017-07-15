<?php
/**
* Created by Manu
* Date: 2017-07-15
* Time: 12:29:12
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\TypeResourceStore;
use Fr\Nj2\Api\models\extended\TypeResource;
use Fr\Nj2\Api\models\extended\ProbaResourceClimate;
use Fr\Nj2\Api\models\business\ProbaResourceClimateBusiness;
use Fr\Nj2\Api\models\extended\Resource;
use Fr\Nj2\Api\models\business\ResourceBusiness;

class TypeResourceCollection extends BaseCollection {

    /**
     * @var ProbaResourceClimateCollection|ProbaResourceClimate[]
     */
    private $cacheProbaResourceClimates = null;
    /**
     * @var ResourceCollection|Resource[]
     */
    private $cacheResources = null;
    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param TypeResource $typeResource
     */
    public function ajout(TypeResource $typeResource) {
        parent::append($typeResource);
    }

    /**
     * Met les TypeResources de la collection dans le TypeResourceStore
     * Vérifie si le TypeResource était déjà storé, dans ce cas, remplace le TypeResource concerné par celui du TypeResourceStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$typeResource) {/** @var TypeResource $typeResource */
            if(TypeResourceStore::exists($typeResource->getId())) $replaces[$offset] = $typeResource;
            else TypeResourceStore::store($typeResource);
        }
        unset($offset);
        foreach($replaces as $offset=>$typeResource) {
            $this->offsetSet($offset, TypeResourceStore::getById($typeResource->getId()));
        }
    }
    
    /**
     * Renvoie les ProbaResourceClimates liés aux TypeResources de cette collection
     * @return ProbaResourceClimateCollection
     */
    public function getProbaResourceClimates() {
        if(is_null($this->cacheProbaResourceClimates)) {
            $this->cacheProbaResourceClimates = ProbaResourceClimateBusiness::getFromTypeResources($this);
            $this->cacheProbaResourceClimates->store();
        }
        return $this->cacheProbaResourceClimates;
    }

    /**
    * Force la collection de probaResourceClimates de this
    * @param ProbaResourceClimateCollection $probaResourceClimates
    */
    public function setProbaResourceClimates(ProbaResourceClimateCollection $probaResourceClimates)
    {
        $this->cacheProbaResourceClimates = $probaResourceClimates;
    }

    /**
    * Remet à null le cache des probaResourceClimates liés à this
    */
    public function resetCacheProbaResourceClimates() {
        $this->cacheProbaResourceClimates = null;
    }

    /**
    * Distribue les ProbaResourceClimates fournis en paramètre à chaque TypeResource de la collection si le ProbaResourceClimate correspond.
    * @param ProbaResourceClimateCollection $probaResourceClimates
    */
    public function fillProbaResourceClimates(ProbaResourceClimateCollection $probaResourceClimates)
    {
        foreach($this as $typeResource) {/** @var TypeResource $typeResource */
            $typeResource->resetCacheProbaResourceClimates();
            $coll = new ProbaResourceClimateCollection();
            $typeResource->setProbaResourceClimates($coll);
            foreach($probaResourceClimates as $probaResourceClimate) {/** @var ProbaResourceClimate $probaResourceClimate */
                if($probaResourceClimate->getIdTypeResource() == $typeResource->getIdTypeResource()) {
                    $coll->ajout($probaResourceClimate);
                }
            }
        }
    }
    
    /**
     * Renvoie les Resources liés aux TypeResources de cette collection
     * @return ResourceCollection
     */
    public function getResources() {
        if(is_null($this->cacheResources)) {
            $this->cacheResources = ResourceBusiness::getFromTypeResources($this);
            $this->cacheResources->store();
        }
        return $this->cacheResources;
    }

    /**
    * Force la collection de resources de this
    * @param ResourceCollection $resources
    */
    public function setResources(ResourceCollection $resources)
    {
        $this->cacheResources = $resources;
    }

    /**
    * Remet à null le cache des resources liés à this
    */
    public function resetCacheResources() {
        $this->cacheResources = null;
    }

    /**
    * Distribue les Resources fournis en paramètre à chaque TypeResource de la collection si le Resource correspond.
    * @param ResourceCollection $resources
    */
    public function fillResources(ResourceCollection $resources)
    {
        foreach($this as $typeResource) {/** @var TypeResource $typeResource */
            $typeResource->resetCacheResources();
            $coll = new ResourceCollection();
            $typeResource->setResources($coll);
            foreach($resources as $resource) {/** @var Resource $resource */
                if($resource->getIdTypeResource() == $typeResource->getIdTypeResource()) {
                    $coll->ajout($resource);
                }
            }
        }
    }
    

    /**
     * @param mixed $index
     * @return TypeResource
     */
    public function offsetGet($index)
    {
        return parent::offsetGet($index);
    }
}