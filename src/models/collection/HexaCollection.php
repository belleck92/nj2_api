<?php
/**
* Created by Manu
* Date: 2017-07-10
* Time: 17:24:40
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\HexaStore;
use Fr\Nj2\Api\models\extended\Hexa;
use Fr\Nj2\Api\models\business\GameBusiness;
use Fr\Nj2\Api\models\extended\Game;
use Fr\Nj2\Api\models\business\TypeClimateBusiness;
use Fr\Nj2\Api\models\extended\TypeClimate;

class HexaCollection extends BaseCollection {

    
    /**
     * @var GameCollection|Game[]
     */
    private $cacheGames = null;
    
    /**
     * @var TypeClimateCollection|TypeClimate[]
     */
    private $cacheTypeClimates = null;
    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Hexa $hexa
     */
    public function ajout(Hexa $hexa) {
        parent::append($hexa);
    }

    /**
     * Met les Hexas de la collection dans le HexaStore
     * Vérifie si le Hexa était déjà storé, dans ce cas, remplace le Hexa concerné par celui du HexaStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$hexa) {/** @var Hexa $hexa */
            if(HexaStore::exists($hexa->getId())) $replaces[$offset] = $hexa;
            else HexaStore::store($hexa);
        }
        unset($offset);
        foreach($replaces as $offset=>$hexa) {
            $this->offsetSet($offset, HexaStore::getById($hexa->getId()));
        }
    }
    
    /**
     * Remet à null le cache des Games liés à la collection
     */
    public function resetCacheGames() {
        $this->cacheGames = null;
    }

    /**
     * Renvoie les Games liés aux Hexas de cette collection
     * @return GameCollection|Game[]
     */
    public function getGames(){
        if(is_null($this->cacheGames)) {
        $this->cacheGames = GameBusiness::getFromHexas($this);
            $this->cacheGames->store();
        }
        return $this->cacheGames;
    }
       
    /**
     * Renvoie une chaîne d'idGame de la collection
     * @return string
     */  
    public function getIdGameStr() {
        $ret = '';
        $prem = true;
        foreach($this as $hexa) {
            if(!$prem) $ret .=',';
            $prem = false;
            $ret .= $hexa->getIdGame();
        }
        return $ret;
    }
    
    /**
     * Remet à null le cache des TypeClimates liés à la collection
     */
    public function resetCacheTypeClimates() {
        $this->cacheTypeClimates = null;
    }

    /**
     * Renvoie les TypeClimates liés aux Hexas de cette collection
     * @return TypeClimateCollection|TypeClimate[]
     */
    public function getTypeClimates(){
        if(is_null($this->cacheTypeClimates)) {
        $this->cacheTypeClimates = TypeClimateBusiness::getFromHexas($this);
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
        foreach($this as $hexa) {
            if(!$prem) $ret .=',';
            $prem = false;
            $ret .= $hexa->getIdTypeClimate();
        }
        return $ret;
    }
    

    /**
     * @param mixed $index
     * @return Hexa
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}