<?php
/**
* Created by Manu
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\SpyBusiness;


class Spy implements Bean {

    /**
     * Primary key
     * @var int
     */
    protected $idSpy;

    /**
     * 
     * @var int
     */
    protected $idPlayer = 0;

    /**
     * 
     * @var int
     */
    protected $idHexa = 0;

    /**
     * Id of the mission type
     * @var int
     */
    protected $idTypeMission = 0;

    /**
     * Id of the target of the mission
     * @var int
     */
    protected $idTarget = 0;

    /**
     * Tells if the spy is infiltrated in the city where he has a mission
     * @var bool
     */
    protected $infiltrated = false;

    /**
     * Number of turns before arrival 1=arrival at next turn resolution
     * @var int
     */
    protected $turnsLeft = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * Primary key
     * @return int
     */
    public function getIdSpy()
    {
        return $this->idSpy;
    }

    /**
     * @param int $idSpy
     */
    public function setIdSpy($idSpy)
    {
        if(empty($this->idSpy)) $this->idSpy = $idSpy;
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
    public function getIdHexa()
    {
        return $this->idHexa;
    }

    /**
     * @param int $idHexa
     */
    public function setIdHexa($idHexa)
    {
        $this->idHexa = $idHexa;
    }
    
    /**
     * Incremente $this->idHexa de $increment
     * @param int $increment
     */
    public function incrIdHexa($increment) {
        $this->setIdHexa($this->getIdHexa() + $increment);
    }
    
    /**
     * Id of the mission type
     * @return int
     */
    public function getIdTypeMission()
    {
        return $this->idTypeMission;
    }

    /**
     * @param int $idTypeMission
     */
    public function setIdTypeMission($idTypeMission)
    {
        $this->idTypeMission = $idTypeMission;
    }
    
    /**
     * Incremente $this->idTypeMission de $increment
     * @param int $increment
     */
    public function incrIdTypeMission($increment) {
        $this->setIdTypeMission($this->getIdTypeMission() + $increment);
    }
    
    /**
     * Id of the target of the mission
     * @return int
     */
    public function getIdTarget()
    {
        return $this->idTarget;
    }

    /**
     * @param int $idTarget
     */
    public function setIdTarget($idTarget)
    {
        $this->idTarget = $idTarget;
    }
    
    /**
     * Incremente $this->idTarget de $increment
     * @param int $increment
     */
    public function incrIdTarget($increment) {
        $this->setIdTarget($this->getIdTarget() + $increment);
    }
    
    /**
     * Tells if the spy is infiltrated in the city where he has a mission
     * @return bool
     */
    public function getInfiltrated()
    {
        return $this->infiltrated;
    }

    /**
     * @param bool $infiltrated
     */
    public function setInfiltrated($infiltrated)
    {
        $this->infiltrated = $infiltrated;
    }
    
    /**
     * Number of turns before arrival 1=arrival at next turn resolution
     * @return int
     */
    public function getTurnsLeft()
    {
        return $this->turnsLeft;
    }

    /**
     * @param int $turnsLeft
     */
    public function setTurnsLeft($turnsLeft)
    {
        $this->turnsLeft = $turnsLeft;
    }
    
    /**
     * Incremente $this->turnsLeft de $increment
     * @param int $increment
     */
    public function incrTurnsLeft($increment) {
        $this->setTurnsLeft($this->getTurnsLeft() + $increment);
    }
    
    /**
     * @return void
     */
    public function save()
    {
        SpyBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdSpy();
    }

    /**
     * @return void
     */
    public function delete()
    {
        SpyBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdSpy($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idSpy'=>$this->idSpy
            ,'idPlayer'=>$this->idPlayer
            ,'idHexa'=>$this->idHexa
            ,'idTypeMission'=>$this->idTypeMission
            ,'idTarget'=>$this->idTarget
            ,'infiltrated'=>$this->infiltrated
            ,'turnsLeft'=>$this->turnsLeft
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(SpyBusiness::getFields())) as $field=>$val) {
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