<?php
/**
* Created by Manu
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\TypeBuildingBusiness;


class TypeBuilding implements Bean {

    /**
     * Primary key
     * @var int
     */
    protected $idTypeBuilding;

    /**
     * 
     * @var string
     */
    protected $name = '';

    /**
     * 
     * @var string
     */
    protected $description = '';

    /**
     * 
     * @var string
     */
    protected $fctId = '';

    /**
     * Price of the level 1
     * @var int
     */
    protected $price = 0;

    /**
     * Time of building for 1 level
     * @var int
     */
    protected $buildingTime = 0;

    /**
     * Max level, 0 for infinite
     * @var int
     */
    protected $maxLevel = 0;

    /**
     * level 2 is (1+(priceCoef/100))than level 1 and so on
     * @var int
     */
    protected $priceCoef = 0;

    /**
     * Cost of the building each turn : (maintenancePriceRatio/100)*Total contruction price
     * @var int
     */
    protected $maintenancePriceRatio = 0;

    /**
     * Tells if the building needs some population units to work
     * @var bool
     */
    protected $needsPopulation = false;

    /**
     * Gold to be invested in building role, ex : units production
     * @var int
     */
    protected $investmentCapacity = 0;

    /**
     * When not enough population in the city, priority to get population in slots
     * @var int
     */
    protected $priorityLevel = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * Primary key
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
        if(empty($this->idTypeBuilding)) $this->idTypeBuilding = $idTypeBuilding;
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
     * 
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
     * Price of the level 1
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
     * Time of building for 1 level
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
     * Max level, 0 for infinite
     * @return int
     */
    public function getMaxLevel()
    {
        return $this->maxLevel;
    }

    /**
     * @param int $maxLevel
     */
    public function setMaxLevel($maxLevel)
    {
        $this->maxLevel = $maxLevel;
    }
    
    /**
     * Incremente $this->maxLevel de $increment
     * @param int $increment
     */
    public function incrMaxLevel($increment) {
        $this->setMaxLevel($this->getMaxLevel() + $increment);
    }
    
    /**
     * level 2 is (1+(priceCoef/100))than level 1 and so on
     * @return int
     */
    public function getPriceCoef()
    {
        return $this->priceCoef;
    }

    /**
     * @param int $priceCoef
     */
    public function setPriceCoef($priceCoef)
    {
        $this->priceCoef = $priceCoef;
    }
    
    /**
     * Incremente $this->priceCoef de $increment
     * @param int $increment
     */
    public function incrPriceCoef($increment) {
        $this->setPriceCoef($this->getPriceCoef() + $increment);
    }
    
    /**
     * Cost of the building each turn : (maintenancePriceRatio/100)*Total contruction price
     * @return int
     */
    public function getMaintenancePriceRatio()
    {
        return $this->maintenancePriceRatio;
    }

    /**
     * @param int $maintenancePriceRatio
     */
    public function setMaintenancePriceRatio($maintenancePriceRatio)
    {
        $this->maintenancePriceRatio = $maintenancePriceRatio;
    }
    
    /**
     * Incremente $this->maintenancePriceRatio de $increment
     * @param int $increment
     */
    public function incrMaintenancePriceRatio($increment) {
        $this->setMaintenancePriceRatio($this->getMaintenancePriceRatio() + $increment);
    }
    
    /**
     * Tells if the building needs some population units to work
     * @return bool
     */
    public function getNeedsPopulation()
    {
        return $this->needsPopulation;
    }

    /**
     * @param bool $needsPopulation
     */
    public function setNeedsPopulation($needsPopulation)
    {
        $this->needsPopulation = $needsPopulation;
    }
    
    /**
     * Gold to be invested in building role, ex : units production
     * @return int
     */
    public function getInvestmentCapacity()
    {
        return $this->investmentCapacity;
    }

    /**
     * @param int $investmentCapacity
     */
    public function setInvestmentCapacity($investmentCapacity)
    {
        $this->investmentCapacity = $investmentCapacity;
    }
    
    /**
     * Incremente $this->investmentCapacity de $increment
     * @param int $increment
     */
    public function incrInvestmentCapacity($increment) {
        $this->setInvestmentCapacity($this->getInvestmentCapacity() + $increment);
    }
    
    /**
     * When not enough population in the city, priority to get population in slots
     * @return int
     */
    public function getPriorityLevel()
    {
        return $this->priorityLevel;
    }

    /**
     * @param int $priorityLevel
     */
    public function setPriorityLevel($priorityLevel)
    {
        $this->priorityLevel = $priorityLevel;
    }
    
    /**
     * Incremente $this->priorityLevel de $increment
     * @param int $increment
     */
    public function incrPriorityLevel($increment) {
        $this->setPriorityLevel($this->getPriorityLevel() + $increment);
    }
    
    /**
     * @return void
     */
    public function save()
    {
        TypeBuildingBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdTypeBuilding();
    }

    /**
     * @return void
     */
    public function delete()
    {
        TypeBuildingBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdTypeBuilding($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idTypeBuilding'=>$this->idTypeBuilding
            ,'name'=>$this->name
            ,'description'=>$this->description
            ,'fctId'=>$this->fctId
            ,'price'=>$this->price
            ,'buildingTime'=>$this->buildingTime
            ,'maxLevel'=>$this->maxLevel
            ,'priceCoef'=>$this->priceCoef
            ,'maintenancePriceRatio'=>$this->maintenancePriceRatio
            ,'needsPopulation'=>$this->needsPopulation
            ,'investmentCapacity'=>$this->investmentCapacity
            ,'priorityLevel'=>$this->priorityLevel
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(TypeBuildingBusiness::getFields())) as $field=>$val) {
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