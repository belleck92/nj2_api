<?php
/**
* Created by Manu
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\BuildingBusiness;


class Building implements Bean {

    /**
     * Primary key
     * @var int
     */
    protected $idBuilding;

    /**
     * 
     * @var int
     */
    protected $idHexa = 0;

    /**
     * 
     * @var int
     */
    protected $idTypeBuilding = 0;

    /**
     * 
     * @var int
     */
    protected $actualLevel = 0;

    /**
     * When not on 0 the building is currently in construction to the actualLevel+1
     * @var int
     */
    protected $buildingTurnsLeft = 0;

    /**
     * Number of population working in the building
     * @var int
     */
    protected $populationWorking = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * Primary key
     * @return int
     */
    public function getIdBuilding()
    {
        return $this->idBuilding;
    }

    /**
     * @param int $idBuilding
     */
    public function setIdBuilding($idBuilding)
    {
        if(empty($this->idBuilding)) $this->idBuilding = $idBuilding;
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
     * 
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
     * 
     * @return int
     */
    public function getActualLevel()
    {
        return $this->actualLevel;
    }

    /**
     * @param int $actualLevel
     */
    public function setActualLevel($actualLevel)
    {
        $this->actualLevel = $actualLevel;
    }
    
    /**
     * Incremente $this->actualLevel de $increment
     * @param int $increment
     */
    public function incrActualLevel($increment) {
        $this->setActualLevel($this->getActualLevel() + $increment);
    }
    
    /**
     * When not on 0 the building is currently in construction to the actualLevel+1
     * @return int
     */
    public function getBuildingTurnsLeft()
    {
        return $this->buildingTurnsLeft;
    }

    /**
     * @param int $buildingTurnsLeft
     */
    public function setBuildingTurnsLeft($buildingTurnsLeft)
    {
        $this->buildingTurnsLeft = $buildingTurnsLeft;
    }
    
    /**
     * Incremente $this->buildingTurnsLeft de $increment
     * @param int $increment
     */
    public function incrBuildingTurnsLeft($increment) {
        $this->setBuildingTurnsLeft($this->getBuildingTurnsLeft() + $increment);
    }
    
    /**
     * Number of population working in the building
     * @return int
     */
    public function getPopulationWorking()
    {
        return $this->populationWorking;
    }

    /**
     * @param int $populationWorking
     */
    public function setPopulationWorking($populationWorking)
    {
        $this->populationWorking = $populationWorking;
    }
    
    /**
     * Incremente $this->populationWorking de $increment
     * @param int $increment
     */
    public function incrPopulationWorking($increment) {
        $this->setPopulationWorking($this->getPopulationWorking() + $increment);
    }
    
    /**
     * @return void
     */
    public function save()
    {
        BuildingBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdBuilding();
    }

    /**
     * @return void
     */
    public function delete()
    {
        BuildingBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdBuilding($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idBuilding'=>$this->idBuilding
            ,'idHexa'=>$this->idHexa
            ,'idTypeBuilding'=>$this->idTypeBuilding
            ,'actualLevel'=>$this->actualLevel
            ,'buildingTurnsLeft'=>$this->buildingTurnsLeft
            ,'populationWorking'=>$this->populationWorking
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(BuildingBusiness::getFields())) as $field=>$val) {
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