<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 15:09:50
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\PlayerBusiness;


class Player implements Bean {

    /**
     * @var int
     */
    private $idPlayer;

    /**
     * @var int
     */
    private $idUser = 0;

    /**
     * @var int
     */
    private $idGame = 0;

    /**
     * @var int
     */
    private $idAlliance = 0;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var int
     */
    private $treasure = 0;

    /**
     * @var string
     */
    private $color = '';

    /**
     * @var int
     */
    private $capitalCity = 0;

    /**
     * @var string
     */
    private $lastResolutionEvents = '';

    /**
     * @var int
     */
    private $taxRate = 0;

    /**
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
}