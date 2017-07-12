<?php
/**
* Created by Manu
* Date: 2017-07-12
* Time: 12:12:19
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\TypeUnitBusiness;


class TypeUnit implements Bean {

    /**
     * @var int
     */
    protected $idTypeMission;

    /**
     * @var int
     */
    protected $idTypeHq = 0;

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string
     */
    protected $fctId = '';

    /**
     * @var int
     */
    protected $assault = 0;

    /**
     * @var int
     */
    protected $resistance = 0;

    /**
     * @var int
     */
    protected $mvt = 0;

    /**
     * @var int
     */
    protected $idTypeBuilding = 0;

    /**
     * @var int
     */
    protected $zIndex = 0;

    /**
     * @var bool
     */
    protected $mecanized = false;

    /**
     * @var bool
     */
    protected $motorized = false;

    /**
     * @var int
     */
    protected $visionRange = 0;

    /**
     * @var int
     */
    protected $price = 0;

    /**
     * @var int
     */
    protected $buildingTime = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
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
        if(empty($this->idTypeUnit)) $this->idTypeMission = $idTypeMission;
    }
    
    /**
     * @return int
     */
    public function getIdTypeHq()
    {
        return $this->idTypeHq;
    }

    /**
     * @param int $idTypeHq
     */
    public function setIdTypeHq($idTypeHq)
    {
        $this->idTypeHq = $idTypeHq;
    }
    
    /**
     * Incremente $this->idTypeHq de $increment
     * @param int $increment
     */
    public function incrIdTypeHq($increment) {
        $this->setIdTypeHq($this->getIdTypeHq() + $increment);
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    /**
     * @return string
     */
    public function getFctId()
    {
        return $this->fctId;
    }

    /**
     * @param string $fctId
     */
    public function setFctId($fctId)
    {
        $this->fctId = $fctId;
    }
    
    /**
     * @return int
     */
    public function getAssault()
    {
        return $this->assault;
    }

    /**
     * @param int $assault
     */
    public function setAssault($assault)
    {
        $this->assault = $assault;
    }
    
    /**
     * Incremente $this->assault de $increment
     * @param int $increment
     */
    public function incrAssault($increment) {
        $this->setAssault($this->getAssault() + $increment);
    }
    
    /**
     * @return int
     */
    public function getResistance()
    {
        return $this->resistance;
    }

    /**
     * @param int $resistance
     */
    public function setResistance($resistance)
    {
        $this->resistance = $resistance;
    }
    
    /**
     * Incremente $this->resistance de $increment
     * @param int $increment
     */
    public function incrResistance($increment) {
        $this->setResistance($this->getResistance() + $increment);
    }
    
    /**
     * @return int
     */
    public function getMvt()
    {
        return $this->mvt;
    }

    /**
     * @param int $mvt
     */
    public function setMvt($mvt)
    {
        $this->mvt = $mvt;
    }
    
    /**
     * Incremente $this->mvt de $increment
     * @param int $increment
     */
    public function incrMvt($increment) {
        $this->setMvt($this->getMvt() + $increment);
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
    public function getZIndex()
    {
        return $this->zIndex;
    }

    /**
     * @param int $zIndex
     */
    public function setZIndex($zIndex)
    {
        $this->zIndex = $zIndex;
    }
    
    /**
     * Incremente $this->zIndex de $increment
     * @param int $increment
     */
    public function incrZIndex($increment) {
        $this->setZIndex($this->getZIndex() + $increment);
    }
    
    /**
     * @return bool
     */
    public function getMecanized()
    {
        return $this->mecanized;
    }

    /**
     * @param bool $mecanized
     */
    public function setMecanized($mecanized)
    {
        $this->mecanized = $mecanized;
    }
    
    /**
     * @return bool
     */
    public function getMotorized()
    {
        return $this->motorized;
    }

    /**
     * @param bool $motorized
     */
    public function setMotorized($motorized)
    {
        $this->motorized = $motorized;
    }
    
    /**
     * @return int
     */
    public function getVisionRange()
    {
        return $this->visionRange;
    }

    /**
     * @param int $visionRange
     */
    public function setVisionRange($visionRange)
    {
        $this->visionRange = $visionRange;
    }
    
    /**
     * Incremente $this->visionRange de $increment
     * @param int $increment
     */
    public function incrVisionRange($increment) {
        $this->setVisionRange($this->getVisionRange() + $increment);
    }
    
    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
    
    /**
     * Incremente $this->price de $increment
     * @param int $increment
     */
    public function incrPrice($increment) {
        $this->setPrice($this->getPrice() + $increment);
    }
    
    /**
     * @return int
     */
    public function getBuildingTime()
    {
        return $this->buildingTime;
    }

    /**
     * @param int $buildingTime
     */
    public function setBuildingTime($buildingTime)
    {
        $this->buildingTime = $buildingTime;
    }
    
    /**
     * Incremente $this->buildingTime de $increment
     * @param int $increment
     */
    public function incrBuildingTime($increment) {
        $this->setBuildingTime($this->getBuildingTime() + $increment);
    }
    
    /**
     * @return void
     */
    public function save()
    {
        TypeUnitBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdTypeMission();
    }

    /**
     * @return void
     */
    public function delete()
    {
        TypeUnitBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdTypeMission($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idTypeMission'=>$this->idTypeMission
            ,'idTypeHq'=>$this->idTypeHq
            ,'name'=>$this->name
            ,'description'=>$this->description
            ,'fctId'=>$this->fctId
            ,'assault'=>$this->assault
            ,'resistance'=>$this->resistance
            ,'mvt'=>$this->mvt
            ,'idTypeBuilding'=>$this->idTypeBuilding
            ,'zIndex'=>$this->zIndex
            ,'mecanized'=>$this->mecanized
            ,'motorized'=>$this->motorized
            ,'visionRange'=>$this->visionRange
            ,'price'=>$this->price
            ,'buildingTime'=>$this->buildingTime
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(TypeUnitBusiness::getFields())) as $field=>$val) {
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