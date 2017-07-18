<?php
/**
* Created by Manu
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\GameBusiness;
use Fr\Nj2\Api\models\collection\HexaCollection;
use Fr\Nj2\Api\models\business\HexaBusiness;
use Fr\Nj2\Api\models\extended\Hexa;
use Fr\Nj2\Api\models\collection\PlayerCollection;
use Fr\Nj2\Api\models\business\PlayerBusiness;
use Fr\Nj2\Api\models\extended\Player;


class Game implements Bean {

    /**
     * @var int
     */
    protected $idGame;

    /**
     * @var int
     */
    protected $currentTurn = 0;

    /**
     * @var int
     */
    protected $maxTurns = 0;

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var bool
     */
    protected $started = false;

    /**
     * @var int
     */
    protected $width = 0;

    /**
     * @var int
     */
    protected $height = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * @var HexaCollection|Hexa[]
     */
    protected $cacheHexas = null;

    /**
     * @var PlayerCollection|Player[]
     */
    protected $cachePlayers = null;

    /**
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
        if(empty($this->idGame)) $this->idGame = $idGame;
    }
    
    /**
     * @return int
     */
    public function getCurrentTurn()
    {
        return $this->currentTurn;
    }

    /**
     * @param int $currentTurn
     */
    public function setCurrentTurn($currentTurn)
    {
        $this->currentTurn = $currentTurn;
    }
    
    /**
     * Incremente $this->currentTurn de $increment
     * @param int $increment
     */
    public function incrCurrentTurn($increment) {
        $this->setCurrentTurn($this->getCurrentTurn() + $increment);
    }
    
    /**
     * @return int
     */
    public function getMaxTurns()
    {
        return $this->maxTurns;
    }

    /**
     * @param int $maxTurns
     */
    public function setMaxTurns($maxTurns)
    {
        $this->maxTurns = $maxTurns;
    }
    
    /**
     * Incremente $this->maxTurns de $increment
     * @param int $increment
     */
    public function incrMaxTurns($increment) {
        $this->setMaxTurns($this->getMaxTurns() + $increment);
    }
    
    /**
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
     * @return bool
     */
    public function getStarted()
    {
        return $this->started;
    }

    /**
     * @param bool $started
     */
    public function setStarted($started)
    {
        $this->started = $started;
    }
    
    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }
    
    /**
     * Incremente $this->width de $increment
     * @param int $increment
     */
    public function incrWidth($increment) {
        $this->setWidth($this->getWidth() + $increment);
    }
    
    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }
    
    /**
     * Incremente $this->height de $increment
     * @param int $increment
     */
    public function incrHeight($increment) {
        $this->setHeight($this->getHeight() + $increment);
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
     * Renvoie les hexas liés à ce Game
     * @return HexaCollection|Hexa[]
     */
    public function getHexas() {
        if(is_null($this->cacheHexas)) {
            $this->cacheHexas = HexaBusiness::getByGame($this);
            $this->cacheHexas->store();
        }
        return $this->cacheHexas;
    }

    /**
     * Crée un hexa lié à ce Game
     * @return extended\Hexa
     */
    public function createHexa(){
        $hexa = new extended\Hexa();
        $hexa->setIdGameRef($this->idGame);
        return $hexa;
    }

    /**
     * Remet à null le cache des players liés à this
     */
    public function resetCachePlayers() {
        $this->cachePlayers = null;
    }

    /**
    * Force la collection de players de this
    * @param PlayerCollection $players
    */
    public function setPlayers(PlayerCollection $players)
    {
        $this->cachePlayers = $players;
    }

    /**
     * Renvoie les players liés à ce Game
     * @return PlayerCollection|Player[]
     */
    public function getPlayers() {
        if(is_null($this->cachePlayers)) {
            $this->cachePlayers = PlayerBusiness::getByGame($this);
            $this->cachePlayers->store();
        }
        return $this->cachePlayers;
    }

    /**
     * Crée un player lié à ce Game
     * @return extended\Player
     */
    public function createPlayer(){
        $player = new extended\Player();
        $player->setIdGameRef($this->idGame);
        return $player;
    }

    /**
     * @return void
     */
    public function save()
    {
        GameBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdGame();
    }

    /**
     * @return void
     */
    public function delete()
    {
        GameBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdGame($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idGame'=>$this->idGame
            ,'currentTurn'=>$this->currentTurn
            ,'maxTurns'=>$this->maxTurns
            ,'name'=>$this->name
            ,'started'=>$this->started
            ,'width'=>$this->width
            ,'height'=>$this->height
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(GameBusiness::getFields())) as $field=>$val) {
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