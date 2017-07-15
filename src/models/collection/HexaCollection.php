<?php
/**
* Created by Manu
* Date: 2017-07-15
* Time: 12:29:12
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\HexaStore;
use Fr\Nj2\Api\models\extended\Hexa;
use Fr\Nj2\Api\models\business\GameBusiness;
use Fr\Nj2\Api\models\extended\Game;
use Fr\Nj2\Api\models\business\TypeClimateBusiness;
use Fr\Nj2\Api\models\extended\TypeClimate;
use Fr\Nj2\Api\models\extended\Resource;
use Fr\Nj2\Api\models\business\ResourceBusiness;
use Fr\Nj2\Api\models\extended\River;
use Fr\Nj2\Api\models\business\RiverBusiness;

class HexaCollection extends BaseCollection {

    /**
     * @var ResourceCollection|Resource[]
     */
    private $cacheResources = null;
    /**
     * @var RiverCollection|River[]
     */
    private $cacheRivers = null;
    
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
     * Renvoie les Resources liés aux Hexas de cette collection
     * @return ResourceCollection
     */
    public function getResources() {
        if(is_null($this->cacheResources)) {
            $this->cacheResources = ResourceBusiness::getFromHexas($this);
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
    * Distribue les Resources fournis en paramètre à chaque Hexa de la collection si le Resource correspond.
    * @param ResourceCollection $resources
    */
    public function fillResources(ResourceCollection $resources)
    {
        foreach($this as $hexa) {/** @var Hexa $hexa */
            $hexa->resetCacheResources();
            $coll = new ResourceCollection();
            $hexa->setResources($coll);
            foreach($resources as $resource) {/** @var Resource $resource */
                if($resource->getIdHexa() == $hexa->getIdHexa()) {
                    $coll->ajout($resource);
                }
            }
        }
    }
    
    /**
     * Renvoie les Rivers liés aux Hexas de cette collection
     * @return RiverCollection
     */
    public function getRivers() {
        if(is_null($this->cacheRivers)) {
            $this->cacheRivers = RiverBusiness::getFromHexas($this);
            $this->cacheRivers->store();
        }
        return $this->cacheRivers;
    }

    /**
    * Force la collection de rivers de this
    * @param RiverCollection $rivers
    */
    public function setRivers(RiverCollection $rivers)
    {
        $this->cacheRivers = $rivers;
    }

    /**
    * Remet à null le cache des rivers liés à this
    */
    public function resetCacheRivers() {
        $this->cacheRivers = null;
    }

    /**
    * Distribue les Rivers fournis en paramètre à chaque Hexa de la collection si le River correspond.
    * @param RiverCollection $rivers
    */
    public function fillRivers(RiverCollection $rivers)
    {
        foreach($this as $hexa) {/** @var Hexa $hexa */
            $hexa->resetCacheRivers();
            $coll = new RiverCollection();
            $hexa->setRivers($coll);
            foreach($rivers as $river) {/** @var River $river */
                if($river->getIdHexa() == $hexa->getIdHexa()) {
                    $coll->ajout($river);
                }
            }
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
     * @return GameCollection
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
     * @return TypeClimateCollection
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
        return parent::offsetGet($index);
    }
}