<?php
/**
* Created by Manu
* Date: 2017-07-10
* Time: 17:24:40
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\TypeClimateStore;
use Fr\Nj2\Api\models\extended\TypeClimate;
use Fr\Nj2\Api\models\extended\Hexa;
use Fr\Nj2\Api\models\business\HexaBusiness;

class TypeClimateCollection extends BaseCollection {

    /**
     * @var HexaCollection|Hexa[]
     */
    private $cacheHexas = null;
    
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
     * @return HexaCollection|Hexa[]
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
            foreach($hexas as $hexa) {
                if($hexa->getIdTypeClimate() == $typeClimate->getIdTypeClimate()) {
                    $coll->ajout($hexa);
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
        parent::offsetGet($index);
    }
}