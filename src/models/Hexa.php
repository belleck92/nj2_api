<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:39
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\HexaBusiness;


class Hexa implements Bean {

    /**
     * @var int
     */
    private $idHexa;

    /**
     * @var int
     */
    private $idGame = 0;

    /**
     * @var int
     */
    private $idPlayer = 0;

    /**
     * @var int
     */
    private $idTerritory = 0;

    /**
     * @var int
     */
    private $idTypeClimate = 0;

    /**
     * @var int
     */
    private $X = 0;

    /**
     * @var int
     */
    private $Y = 0;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var int
     */
    private $population = 0;

    /**
     * @var int
     */
    private $malusConquest = 0;

    /**
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
}