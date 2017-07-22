<?php
/**
* Created by Manu
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\PlayerBusiness;
use Fr\Nj2\Api\models\collection\VisibilityCollection;
use Fr\Nj2\Api\models\business\VisibilityBusiness;
use Fr\Nj2\Api\models\extended\Visibility;
use Fr\Nj2\Api\models\collection\HexaCollection;
use Fr\Nj2\Api\models\business\HexaBusiness;
use Fr\Nj2\Api\models\extended\Hexa;
use Fr\Nj2\Api\models\store\GameStore;
use Fr\Nj2\Api\models\store\UserStore;


class Player implements Bean {

    /**
     * Primary key
     * @var int
     */
    protected $idPlayer;

    /**
     * 
     * @var int
     */
    protected $idUser = 0;

    /**
     * 
     * @var int
     */
    protected $idGame = 0;

    /**
     * 
     * @var int
     */
    protected $idAlliance = 0;

    /**
     * 
     * @var string
     */
    protected $name = '';

    /**
     * 
     * @var int
     */
    protected $treasure = 0;

    /**
     * 
     * @var string
     */
    protected $color = '';

    /**
     * 
     * @var int
     */
    protected $capitalCity = 0;

    /**
     * A JSON describing the last turn events the player can see
     * @var string
     */
    protected $lastResolutionEvents = '';

    /**
     * Percentage, from 0 to 100
     * @var int
     */
    protected $taxRate = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * @var VisibilityCollection|Visibility[]
     */
    protected $cacheVisibilitys = null;

    /**
     * @var HexaCollection|Hexa[]
     */
    protected $cacheHexas = null;

    /**
     * Primary key
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
        if(empty($this->idPlayer)) $this->idPlayer = $idPlayer;
    }
    
    /**
     * 
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }
    
    /**
     * Incremente $this->idUser de $increment
     * @param int $increment
     */
    public function incrIdUser($increment) {
        $this->setIdUser($this->getIdUser() + $increment);
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
    public function getIdAlliance()
    {
        return $this->idAlliance;
    }

    /**
     * @param int $idAlliance
     */
    public function setIdAlliance($idAlliance)
    {
        $this->idAlliance = $idAlliance;
    }
    
    /**
     * Incremente $this->idAlliance de $increment
     * @param int $increment
     */
    public function incrIdAlliance($increment) {
        $this->setIdAlliance($this->getIdAlliance() + $increment);
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
     * 
     * @return int
     */
    public function getTreasure()
    {
        return $this->treasure;
    }

    /**
     * @param int $treasure
     */
    public function setTreasure($treasure)
    {
        $this->treasure = $treasure;
    }
    
    /**
     * Incremente $this->treasure de $increment
     * @param int $increment
     */
    public function incrTreasure($increment) {
        $this->setTreasure($this->getTreasure() + $increment);
    }
    
    /**
     * 
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }
    
    /**
     * 
     * @return int
     */
    public function getCapitalCity()
    {
        return $this->capitalCity;
    }

    /**
     * @param int $capitalCity
     */
    public function setCapitalCity($capitalCity)
    {
        $this->capitalCity = $capitalCity;
    }
    
    /**
     * Incremente $this->capitalCity de $increment
     * @param int $increment
     */
    public function incrCapitalCity($increment) {
        $this->setCapitalCity($this->getCapitalCity() + $increment);
    }
    
    /**
     * A JSON describing the last turn events the player can see
     * @return string
     */
    public function getLastResolutionEvents()
    {
        return $this->lastResolutionEvents;
    }

    /**
     * @param string $lastResolutionEvents
     */
    public function setLastResolutionEvents($lastResolutionEvents)
    {
        $this->lastResolutionEvents = $lastResolutionEvents;
    }
    
    /**
     * Percentage, from 0 to 100
     * @return int
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }

    /**
     * @param int $taxRate
     */
    public function setTaxRate($taxRate)
    {
        $this->taxRate = $taxRate;
    }
    
    /**
     * Incremente $this->taxRate de $increment
     * @param int $increment
     */
    public function incrTaxRate($increment) {
        $this->setTaxRate($this->getTaxRate() + $increment);
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
     * Renvoie le user lié
     * @return extended\User
     */
    public function getUser()
    {
        return UserStore::getById($this->getIdUser());
    }

    /**
     * Links the idUser of the User object
     * @param int $idUser
    */
    public function setIdUserRef(&$idUser)
    {
        $this->idUser = $idUser;
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
     * Renvoie les visibilitys liés à ce Player
     * @return VisibilityCollection|Visibility[]
     */
    public function getVisibilitys() {
        if(is_null($this->cacheVisibilitys)) {
            $this->cacheVisibilitys = VisibilityBusiness::getByPlayer($this);
            $this->cacheVisibilitys->store();
        }
        return $this->cacheVisibilitys;
    }

    /**
     * Crée un visibility lié à ce Player
     * @return extended\Visibility
     */
    public function createVisibility(){
        $visibility = new extended\Visibility();
        $visibility->setIdPlayerRef($this->idPlayer);
        return $visibility;
    }

    /**
     * Remet à null le cache des hexas liés à this
     */
    public function resetCacheHexas() {
        $this->cacheHexas = null;
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
     * Renvoie les hexas liés à ce Player
     * @return HexaCollection|Hexa[]
     */
    public function getHexas() {
        if(is_null($this->cacheHexas)) {
            $this->cacheHexas = HexaBusiness::getByPlayer($this);
            $this->cacheHexas->store();
        }
        return $this->cacheHexas;
    }

    /**
     * Crée un hexa lié à ce Player
     * @return extended\Hexa
     */
    public function createHexa(){
        $hexa = new extended\Hexa();
        $hexa->setIdTerritoryRef($this->idPlayer);
        return $hexa;
    }

    /**
     * @return void
     */
    public function save()
    {
        PlayerBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdPlayer();
    }

    /**
     * @return void
     */
    public function delete()
    {
        PlayerBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdPlayer($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idPlayer'=>$this->idPlayer
            ,'idUser'=>$this->idUser
            ,'idGame'=>$this->idGame
            ,'idAlliance'=>$this->idAlliance
            ,'name'=>$this->name
            ,'treasure'=>$this->treasure
            ,'color'=>$this->color
            ,'capitalCity'=>$this->capitalCity
            ,'lastResolutionEvents'=>$this->lastResolutionEvents
            ,'taxRate'=>$this->taxRate
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(PlayerBusiness::getFields())) as $field=>$val) {
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