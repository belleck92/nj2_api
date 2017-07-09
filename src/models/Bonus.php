<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 15:09:50
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\BonusBusiness;


class Bonus implements Bean {

    /**
     * @var int
     */
    private $idBonus;

    /**
     * @var int
     */
    private $idTypeBonus = 0;

    /**
     * @var int
     */
    private $idTypeBuilding = 0;

    /**
     * @var int
     */
    private $era = 0;

    /**
     * @var int
     */
    private $idTypeResource = 0;

    /**
     * @var int
     */
    private $idTypeUnit = 0;

    /**
     * @var int
     */
    private $value = 0;

    /**
     * @return int
     */
    public function getIdBonus()
    {
        return $this->idBonus;
    }

    /**
     * @param int $idBonus
     */
    public function setIdBonus($idBonus)
    {
        if(empty($this->idBonus)) $this->idBonus = $idBonus;
    }
    
    /**
     * @return int
     */
    public function getIdTypeBonus()
    {
        return $this->idTypeBonus;
    }

    /**
     * @param int $idTypeBonus
     */
    public function setIdTypeBonus($idTypeBonus)
    {
        $this->idTypeBonus = $idTypeBonus;
    }
    
    /**
     * Incremente $this->idTypeBonus de $increment
     * @param int $increment
     */
    public function incrIdTypeBonus($increment) {
        $this->setIdTypeBonus($this->getIdTypeBonus() + $increment);
    }
    
    /**
     * @return int
     */
    public function getIdTypeBuilding()
    {
        return $this->idTypeBuilding;
    }

    /**
     * @param int $idTypeBuilding
     */
    public function setIdTypeBuilding($idTypeBuilding)
    {
        $this->idTypeBuilding = $idTypeBuilding;
    }
    
    /**
     * Incremente $this->idTypeBuilding de $increment
     * @param int $increment
     */
    public function incrIdTypeBuilding($increment) {
        $this->setIdTypeBuilding($this->getIdTypeBuilding() + $increment);
    }
    
    /**
     * @return int
     */
    public function getEra()
    {
        return $this->era;
    }

    /**
     * @param int $era
     */
    public function setEra($era)
    {
        $this->era = $era;
    }
    
    /**
     * Incremente $this->era de $increment
     * @param int $increment
     */
    public function incrEra($increment) {
        $this->setEra($this->getEra() + $increment);
    }
    
    /**
     * @return int
     */
    public function getIdTypeResource()
    {
        return $this->idTypeResource;
    }

    /**
     * @param int $idTypeResource
     */
    public function setIdTypeResource($idTypeResource)
    {
        $this->idTypeResource = $idTypeResource;
    }
    
    /**
     * Incremente $this->idTypeResource de $increment
     * @param int $increment
     */
    public function incrIdTypeResource($increment) {
        $this->setIdTypeResource($this->getIdTypeResource() + $increment);
    }
    
    /**
     * @return int
     */
    public function getIdTypeUnit()
    {
        return $this->idTypeUnit;
    }

    /**
     * @param int $idTypeUnit
     */
    public function setIdTypeUnit($idTypeUnit)
    {
        $this->idTypeUnit = $idTypeUnit;
    }
    
    /**
     * Incremente $this->idTypeUnit de $increment
     * @param int $increment
     */
    public function incrIdTypeUnit($increment) {
        $this->setIdTypeUnit($this->getIdTypeUnit() + $increment);
    }
    
    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
    
    /**
     * Incremente $this->value de $increment
     * @param int $increment
     */
    public function incrValue($increment) {
        $this->setValue($this->getValue() + $increment);
    }
    
    /**
     * @return void
     */
    public function save()
    {
        BonusBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdBonus();
    }

    /**
     * @return void
     */
    public function delete()
    {
        BonusBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdBonus($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idBonus'=>$this->idBonus
            ,'idTypeBonus'=>$this->idTypeBonus
            ,'idTypeBuilding'=>$this->idTypeBuilding
            ,'era'=>$this->era
            ,'idTypeResource'=>$this->idTypeResource
            ,'idTypeUnit'=>$this->idTypeUnit
            ,'value'=>$this->value
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(BonusBusiness::getFields())) as $field=>$val) {
            $method = 'set'.BaseBusiness::lowerToUpperCamelCase($field);
            $this->$method($val);
        }
    }
}