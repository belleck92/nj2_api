<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\HexaStore;
use Fr\Nj2\Api\models\extended\Hexa;
use Fr\Nj2\Api\models\business\GameBusiness;
use Fr\Nj2\Api\models\extended\Game;
use Fr\Nj2\Api\models\business\TypeClimateBusiness;
use Fr\Nj2\Api\models\extended\TypeClimate;
use Fr\Nj2\Api\models\business\PlayerBusiness;
use Fr\Nj2\Api\models\extended\Player;
use Fr\Nj2\Api\models\extended\Resource;
use Fr\Nj2\Api\models\business\ResourceBusiness;
use Fr\Nj2\Api\models\extended\Visibility;
use Fr\Nj2\Api\models\business\VisibilityBusiness;
use Fr\Nj2\Api\models\extended\River;
use Fr\Nj2\Api\models\business\RiverBusiness;

class HexaCollection extends BaseCollection {

    /**
     * @var ResourceCollection|Resource[]
     */
    private $cacheResources = null;
    /**
     * @var VisibilityCollection|Visibility[]
     */
    private $cacheVisibilitys = null;
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
     * @var PlayerCollection|Player[]
     */
    private $cachePlayers = null;
    
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
     * Renvoie les Visibilitys liés aux Hexas de cette collection
     * @return VisibilityCollection
     */
    public function getVisibilitys() {
        if(is_null($this->cacheVisibilitys)) {
            $this->cacheVisibilitys = VisibilityBusiness::getFromHexas($this);
            $this->cacheVisibilitys->store();
        }
        return $this->cacheVisibilitys;
    }

    /**
    * Force la collection de visibilitys de this
    * @param VisibilityCollection $visibilitys
    */
    public function setVisibilitys(VisibilityCollection $visibilitys)
    {
        $this->cacheVisibilitys = $visibilitys;
    }

    /**
    * Remet à null le cache des visibilitys liés à this
    */
    public function resetCacheVisibilitys() {
        $this->cacheVisibilitys = null;
    }

    /**
    * Distribue les Visibilitys fournis en paramètre à chaque Hexa de la collection si le Visibility correspond.
    * @param VisibilityCollection $visibilitys
    */
    public function fillVisibilitys(VisibilityCollection $visibilitys)
    {
        foreach($this as $hexa) {/** @var Hexa $hexa */
            $hexa->resetCacheVisibilitys();
            $coll = new VisibilityCollection();
            $hexa->setVisibilitys($coll);
            foreach($visibilitys as $visibility) {/** @var Visibility $visibility */
                if($visibility->getIdHexa() == $hexa->getIdHexa()) {
                    $coll->ajout($visibility);
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
     * Remet à null le cache des Players liés à la collection
     */
    public function resetCachePlayers() {
        $this->cachePlayers = null;
    }

    /**
     * Renvoie les Players liés aux Hexas de cette collection
     * @return PlayerCollection
     */
    public function getPlayers(){
        if(is_null($this->cachePlayers)) {
        $this->cachePlayers = PlayerBusiness::getFromHexas($this);
            $this->cachePlayers->store();
        }
        return $this->cachePlayers;
    }
       
    /**
     * Renvoie une chaîne d'idTerritory de la collection
     * @return string
     */  
    public function getIdTerritoryStr() {
        $ret = '';
        $prem = true;
        foreach($this as $hexa) {
            if(!$prem) $ret .=',';
            $prem = false;
            $ret .= $hexa->getIdTerritory();
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