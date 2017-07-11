<?php
/**
* Created by Manu
* Date: 2017-07-11
* Time: 17:29:12
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\TypeResourceStore;
use Fr\Nj2\Api\models\extended\TypeResource;
use Fr\Nj2\Api\models\extended\ProbaResourceClimate;
use Fr\Nj2\Api\models\business\ProbaResourceClimateBusiness;

class TypeResourceCollection extends BaseCollection {

    /**
     * @var ProbaResourceClimateCollection|ProbaResourceClimate[]
     */
    private $cacheProbaResourceClimates = null;
    
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
     * @return ProbaResourceClimateCollection|ProbaResourceClimate[]
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
            foreach($probaResourceClimates as $probaResourceClimate) {
                if($probaResourceClimate->getIdTypeResource() == $typeResource->getIdTypeResource()) {
                    $coll->ajout($probaResourceClimate);
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
        parent::offsetGet($index);
    }
}