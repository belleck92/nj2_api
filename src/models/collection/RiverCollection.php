<?php
/**
* Created by Manu
* Date: 2017-07-15
* Time: 12:29:12
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\RiverStore;
use Fr\Nj2\Api\models\extended\River;
use Fr\Nj2\Api\models\business\HexaBusiness;
use Fr\Nj2\Api\models\extended\Hexa;

class RiverCollection extends BaseCollection {

    
    /**
     * @var HexaCollection|Hexa[]
     */
    private $cacheHexas = null;
    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param River $river
     */
    public function ajout(River $river) {
        parent::append($river);
    }

    /**
     * Met les Rivers de la collection dans le RiverStore
     * Vérifie si le River était déjà storé, dans ce cas, remplace le River concerné par celui du RiverStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$river) {/** @var River $river */
            if(RiverStore::exists($river->getId())) $replaces[$offset] = $river;
            else RiverStore::store($river);
        }
        unset($offset);
        foreach($replaces as $offset=>$river) {
            $this->offsetSet($offset, RiverStore::getById($river->getId()));
        }
    }
    
    /**
     * Remet à null le cache des Hexas liés à la collection
     */
    public function resetCacheHexas() {
        $this->cacheHexas = null;
    }

    /**
     * Renvoie les Hexas liés aux Rivers de cette collection
     * @return HexaCollection
     */
    public function getHexas(){
        if(is_null($this->cacheHexas)) {
        $this->cacheHexas = HexaBusiness::getFromRivers($this);
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
        foreach($this as $river) {
            if(!$prem) $ret .=',';
            $prem = false;
            $ret .= $river->getIdHexa();
        }
        return $ret;
    }
    

    /**
     * @param mixed $index
     * @return River
     */
    public function offsetGet($index)
    {
        return parent::offsetGet($index);
    }
}