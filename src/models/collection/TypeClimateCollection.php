<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\TypeClimateStore;
use Fr\Nj2\Api\models\extended\TypeClimate;
use Fr\Nj2\Api\models\extended\Hexa;
use Fr\Nj2\Api\models\business\HexaBusiness;
use Fr\Nj2\Api\models\extended\ProbaResourceClimate;
use Fr\Nj2\Api\models\business\ProbaResourceClimateBusiness;

class TypeClimateCollection extends BaseCollection {

    /**
     * @var HexaCollection|Hexa[]
     */
    private $cacheHexas = null;
    /**
     * @var ProbaResourceClimateCollection|ProbaResourceClimate[]
     */
    private $cacheProbaResourceClimates = null;
    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param TypeClimate $typeClimate
     */
    public function ajout(TypeClimate $typeClimate) {
        parent::append($typeClimate);
    }

    /**
     * Met les TypeClimates de la collection dans le TypeClimateStore
     * Vérifie si le TypeClimate était déjà storé, dans ce cas, remplace le TypeClimate concerné par celui du TypeClimateStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$typeClimate) {/** @var TypeClimate $typeClimate */
            if(TypeClimateStore::exists($typeClimate->getId())) $replaces[$offset] = $typeClimate;
            else TypeClimateStore::store($typeClimate);
        }
        unset($offset);
        foreach($replaces as $offset=>$typeClimate) {
            $this->offsetSet($offset, TypeClimateStore::getById($typeClimate->getId()));
        }
    }
    
    /**
     * Renvoie les Hexas liés aux TypeClimates de cette collection
     * @return HexaCollection
     */
    public function getHexas() {
        if(is_null($this->cacheHexas)) {
            $this->cacheHexas = HexaBusiness::getFromTypeClimates($this);
            $this->cacheHexas->store();
        }
        return $this->cacheHexas;
    }

    /**
    * Force la collection de hexas de this
    * @param HexaCollection $hexas
    */
    public function setHexas(HexaCollection $hexas)
    {
        $this->cacheHexas = $hexas;
    }

    /**
    * Remet à null le cache des hexas liés à this
    */
    public function resetCacheHexas() {
        $this->cacheHexas = null;
    }

    /**
    * Distribue les Hexas fournis en paramètre à chaque TypeClimate de la collection si le Hexa correspond.
    * @param HexaCollection $hexas
    */
    public function fillHexas(HexaCollection $hexas)
    {
        foreach($this as $typeClimate) {/** @var TypeClimate $typeClimate */
            $typeClimate->resetCacheHexas();
            $coll = new HexaCollection();
            $typeClimate->setHexas($coll);
            foreach($hexas as $hexa) {/** @var Hexa $hexa */
                if($hexa->getIdTypeClimate() == $typeClimate->getIdTypeClimate()) {
                    $coll->ajout($hexa);
                }
            }
        }
    }
    
    /**
     * Renvoie les ProbaResourceClimates liés aux TypeClimates de cette collection
     * @return ProbaResourceClimateCollection
     */
    public function getProbaResourceClimates() {
        if(is_null($this->cacheProbaResourceClimates)) {
            $this->cacheProbaResourceClimates = ProbaResourceClimateBusiness::getFromTypeClimates($this);
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
    * Distribue les ProbaResourceClimates fournis en paramètre à chaque TypeClimate de la collection si le ProbaResourceClimate correspond.
    * @param ProbaResourceClimateCollection $probaResourceClimates
    */
    public function fillProbaResourceClimates(ProbaResourceClimateCollection $probaResourceClimates)
    {
        foreach($this as $typeClimate) {/** @var TypeClimate $typeClimate */
            $typeClimate->resetCacheProbaResourceClimates();
            $coll = new ProbaResourceClimateCollection();
            $typeClimate->setProbaResourceClimates($coll);
            foreach($probaResourceClimates as $probaResourceClimate) {/** @var ProbaResourceClimate $probaResourceClimate */
                if($probaResourceClimate->getIdTypeClimate() == $typeClimate->getIdTypeClimate()) {
                    $coll->ajout($probaResourceClimate);
                }
            }
        }
    }
    

    /**
     * @param mixed $index
     * @return TypeClimate
     */
    public function offsetGet($index)
    {
        return parent::offsetGet($index);
    }
}