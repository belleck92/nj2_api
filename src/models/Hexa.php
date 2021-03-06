<?php
/**
* Created by Manu
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\HexaBusiness;
use Fr\Nj2\Api\models\collection\ResourceCollection;
use Fr\Nj2\Api\models\business\ResourceBusiness;
use Fr\Nj2\Api\models\extended\Resource;
use Fr\Nj2\Api\models\collection\VisibilityCollection;
use Fr\Nj2\Api\models\business\VisibilityBusiness;
use Fr\Nj2\Api\models\extended\Visibility;
use Fr\Nj2\Api\models\collection\RiverCollection;
use Fr\Nj2\Api\models\business\RiverBusiness;
use Fr\Nj2\Api\models\extended\River;
use Fr\Nj2\Api\models\store\GameStore;
use Fr\Nj2\Api\models\store\TypeClimateStore;
use Fr\Nj2\Api\models\store\PlayerStore;


class Hexa implements Bean {

    /**
     * Primary key
     * @var int
     */
    protected $idHexa;

    /**
     * 
     * @var int
     */
    protected $idGame = 0;

    /**
     * 
     * @var int
     */
    protected $idPlayer = 0;

    /**
     * 
     * @var int
     */
    protected $idTerritory = 0;

    /**
     * 
     * @var int
     */
    protected $idTypeClimate = 0;

    /**
     * 
     * @var int
     */
    protected $X = 0;

    /**
     * 
     * @var int
     */
    protected $Y = 0;

    /**
     * 
     * @var string
     */
    protected $name = '';

    /**
     * The exact number of inhabitants in the city. The size of the city come from a formula using this field.
     * @var int
     */
    protected $population = 0;

    /**
     * In percent. Malus on production, growth, science, etc... of the city due to recent conquest. Decreases by the time
     * @var int
     */
    protected $malusConquest = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * @var ResourceCollection|Resource[]
     */
    protected $cacheResources = null;

    /**
     * @var VisibilityCollection|Visibility[]
     */
    protected $cacheVisibilitys = null;

    /**
     * @var RiverCollection|River[]
     */
    protected $cacheRivers = null;

    /**
     * Primary key
     * @return int
     */
    public function getIdHexa()
    {
        return $this->idHexa;
    }

    /**
     * @param int $idHexa
     */
    public function setIdHexa($idHexa)
    {
        if(empty($this->idHexa)) $this->idHexa = $idHexa;
    }
    
    /**
     * 
     * @return int
     */
    public function getIdGame()
    {
        return $this->idGame;
    }

    /**
     * @param int $idGame
     */
    public function setIdGame($idGame)
    {
        $this->idGame = $idGame;
    }
    
    /**
     * Incremente $this->idGame de $increment
     * @param int $increment
     */
    public function incrIdGame($increment) {
        $this->setIdGame($this->getIdGame() + $increment);
    }
    
    /**
     * 
     * @return int
     */
    public function getIdPlayer()
    {
        return $this->idPlayer;
    }

    /**
     * @param int $idPlayer
     */
    public function setIdPlayer($idPlayer)
    {
        $this->idPlayer = $idPlayer;
    }
    
    /**
     * Incremente $this->idPlayer de $increment
     * @param int $increment
     */
    public function incrIdPlayer($increment) {
        $this->setIdPlayer($this->getIdPlayer() + $increment);
    }
    
    /**
     * 
     * @return int
     */
    public function getIdTerritory()
    {
        return $this->idTerritory;
    }

    /**
     * @param int $idTerritory
     */
    public function setIdTerritory($idTerritory)
    {
        $this->idTerritory = $idTerritory;
    }
    
    /**
     * Incremente $this->idTerritory de $increment
     * @param int $increment
     */
    public function incrIdTerritory($increment) {
        $this->setIdTerritory($this->getIdTerritory() + $increment);
    }
    
    /**
     * 
     * @return int
     */
    public function getIdTypeClimate()
    {
        return $this->idTypeClimate;
    }

    /**
     * @param int $idTypeClimate
     */
    public function setIdTypeClimate($idTypeClimate)
    {
        $this->idTypeClimate = $idTypeClimate;
    }
    
    /**
     * Incremente $this->idTypeClimate de $increment
     * @param int $increment
     */
    public function incrIdTypeClimate($increment) {
        $this->setIdTypeClimate($this->getIdTypeClimate() + $increment);
    }
    
    /**
     * 
     * @return int
     */
    public function getX()
    {
        return $this->X;
    }

    /**
     * @param int $X
     */
    public function setX($X)
    {
        $this->X = $X;
    }
    
    /**
     * Incremente $this->X de $increment
     * @param int $increment
     */
    public function incrX($increment) {
        $this->setX($this->getX() + $increment);
    }
    
    /**
     * 
     * @return int
     */
    public function getY()
    {
        return $this->Y;
    }

    /**
     * @param int $Y
     */
    public function setY($Y)
    {
        $this->Y = $Y;
    }
    
    /**
     * Incremente $this->Y de $increment
     * @param int $increment
     */
    public function incrY($increment) {
        $this->setY($this->getY() + $increment);
    }
    
    /**
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * The exact number of inhabitants in the city. The size of the city come from a formula using this field.
     * @return int
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * @param int $population
     */
    public function setPopulation($population)
    {
        $this->population = $population;
    }
    
    /**
     * Incremente $this->population de $increment
     * @param int $increment
     */
    public function incrPopulation($increment) {
        $this->setPopulation($this->getPopulation() + $increment);
    }
    
    /**
     * In percent. Malus on production, growth, science, etc... of the city due to recent conquest. Decreases by the time
     * @return int
     */
    public function getMalusConquest()
    {
        return $this->malusConquest;
    }

    /**
     * @param int $malusConquest
     */
    public function setMalusConquest($malusConquest)
    {
        $this->malusConquest = $malusConquest;
    }
    
    /**
     * Incremente $this->malusConquest de $increment
     * @param int $increment
     */
    public function incrMalusConquest($increment) {
        $this->setMalusConquest($this->getMalusConquest() + $increment);
    }
    

    /**
     * Renvoie le game lié
     * @return extended\Game
     */
    public function getGame()
    {
        return GameStore::getById($this->getIdGame());
    }

    /**
     * Links the idGame of the Game object
     * @param int $idGame
    */
    public function setIdGameRef(&$idGame)
    {
        $this->idGame = $idGame;
    }


    /**
     * Renvoie le typeClimate lié
     * @return extended\TypeClimate
     */
    public function getTypeClimate()
    {
        return TypeClimateStore::getById($this->getIdTypeClimate());
    }

    /**
     * Links the idTypeClimate of the TypeClimate object
     * @param int $idTypeClimate
    */
    public function setIdTypeClimateRef(&$idTypeClimate)
    {
        $this->idTypeClimate = $idTypeClimate;
    }


    /**
     * Renvoie le player lié
     * @return extended\Player
     */
    public function getPlayer()
    {
        return PlayerStore::getById($this->getIdPlayer());
    }

    /**
     * Links the idPlayer of the Player object
     * @param int $idPlayer
    */
    public function setIdPlayerRef(&$idPlayer)
    {
        $this->idPlayer = $idPlayer;
    }

    /**
     * Remet à null le cache des resources liés à this
     */
    public function resetCacheResources() {
        $this->cacheResources = null;
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
     * Renvoie les resources liés à ce Hexa
     * @return ResourceCollection|Resource[]
     */
    public function getResources() {
        if(is_null($this->cacheResources)) {
            $this->cacheResources = ResourceBusiness::getByHexa($this);
            $this->cacheResources->store();
        }
        return $this->cacheResources;
    }

    /**
     * Crée un resource lié à ce Hexa
     * @return extended\Resource
     */
    public function createResource(){
        $resource = new extended\Resource();
        $resource->setIdHexaRef($this->idHexa);
        return $resource;
    }

    /**
     * Remet à null le cache des visibilitys liés à this
     */
    public function resetCacheVisibilitys() {
        $this->cacheVisibilitys = null;
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
     * Renvoie les visibilitys liés à ce Hexa
     * @return VisibilityCollection|Visibility[]
     */
    public function getVisibilitys() {
        if(is_null($this->cacheVisibilitys)) {
            $this->cacheVisibilitys = VisibilityBusiness::getByHexa($this);
            $this->cacheVisibilitys->store();
        }
        return $this->cacheVisibilitys;
    }

    /**
     * Crée un visibility lié à ce Hexa
     * @return extended\Visibility
     */
    public function createVisibility(){
        $visibility = new extended\Visibility();
        $visibility->setIdHexaRef($this->idHexa);
        return $visibility;
    }

    /**
     * Remet à null le cache des rivers liés à this
     */
    public function resetCacheRivers() {
        $this->cacheRivers = null;
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
     * Renvoie les rivers liés à ce Hexa
     * @return RiverCollection|River[]
     */
    public function getRivers() {
        if(is_null($this->cacheRivers)) {
            $this->cacheRivers = RiverBusiness::getByHexa($this);
            $this->cacheRivers->store();
        }
        return $this->cacheRivers;
    }

    /**
     * Crée un river lié à ce Hexa
     * @return extended\River
     */
    public function createRiver(){
        $river = new extended\River();
        $river->setIdHexaRef($this->idHexa);
        return $river;
    }

    /**
     * @return void
     */
    public function save()
    {
        HexaBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdHexa();
    }

    /**
     * @return void
     */
    public function delete()
    {
        HexaBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdHexa($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idHexa'=>$this->idHexa
            ,'idGame'=>$this->idGame
            ,'idPlayer'=>$this->idPlayer
            ,'idTerritory'=>$this->idTerritory
            ,'idTypeClimate'=>$this->idTypeClimate
            ,'X'=>$this->X
            ,'Y'=>$this->Y
            ,'name'=>$this->name
            ,'population'=>$this->population
            ,'malusConquest'=>$this->malusConquest
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(HexaBusiness::getFields())) as $field=>$val) {
            $method = 'set'.BaseBusiness::lowerToUpperCamelCase($field);
            $this->$method($val);
        }
    }

    /**
     * @return boolean
     */
    public function isExtendedData()
    {
        return $this->extendedData;
    }

    /**
     * @param boolean $extendedData
     */
    public function setExtendedData($extendedData)
    {
        $this->extendedData = $extendedData;
    }
}