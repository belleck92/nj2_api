<?php
/**
* Created by Manu
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\BonusBusiness;


class Bonus implements Bean {

    /**
     * Primary key
     * @var int
     */
    protected $idBonus;

    /**
     * 
     * @var int
     */
    protected $idTypeBonus = 0;

    /**
     * The building permitted by this bonus or the building type concerned by the investment bonus
     * @var int
     */
    protected $idTypeBuilding = 0;

    /**
     * The era of the building if the bonus permits a building. The era of the bonus if it's a resource bonus
     * @var int
     */
    protected $era = 0;

    /**
     * The resource permitted by this bonus
     * @var int
     */
    protected $idTypeResource = 0;

    /**
     * The unit permitted by this bonus or the unit type concerned by the investment bonus
     * @var int
     */
    protected $idTypeUnit = 0;

    /**
     * Value of the bonus, in percent, if its not a bonus that permits to use an entity
     * @var int
     */
    protected $value = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * Primary key
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
     * 
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
     * The building permitted by this bonus or the building type concerned by the investment bonus
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
     * The era of the building if the bonus permits a building. The era of the bonus if it's a resource bonus
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
     * The resource permitted by this bonus
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
     * The unit permitted by this bonus or the unit type concerned by the investment bonus
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
     * Value of the bonus, in percent, if its not a bonus that permits to use an entity
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