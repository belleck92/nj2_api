<?php
/**
* Created by Manu
* Date: 2017-07-15
* Time: 12:29:12
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\TypeMissionBusiness;


class TypeMission implements Bean {

    /**
     * @var int
     */
    protected $idTypeMission;

    /**
     * @var int
     */
    protected $unitOrSpy = 0;

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
        if(empty($this->idTypeMission)) $this->idTypeMission = $idTypeMission;
    }
    
    /**
     * @return int
     */
    public function getUnitOrSpy()
    {
        return $this->unitOrSpy;
    }

    /**
     * @param int $unitOrSpy
     */
    public function setUnitOrSpy($unitOrSpy)
    {
        $this->unitOrSpy = $unitOrSpy;
    }
    
    /**
     * Incremente $this->unitOrSpy de $increment
     * @param int $increment
     */
    public function incrUnitOrSpy($increment) {
        $this->setUnitOrSpy($this->getUnitOrSpy() + $increment);
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
     * @return void
     */
    public function save()
    {
        TypeMissionBusiness::save($this);
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
        TypeMissionBusiness::delete($this);
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
            ,'unitOrSpy'=>$this->unitOrSpy
            ,'name'=>$this->name
            ,'description'=>$this->description
            ,'fctId'=>$this->fctId
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(TypeMissionBusiness::getFields())) as $field=>$val) {
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