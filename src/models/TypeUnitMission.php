<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\TypeUnitMissionBusiness;


class TypeUnitMission implements Bean {

    /**
     * @var int
     */
    private $idTypeUnitMission;

    /**
     * @var int
     */
    private $idTypeUnit = 0;

    /**
     * @var int
     */
    private $idTypeMission = 0;

    /**
     * @return int
     */
    public function getIdTypeUnitMission()
    {
        return $this->idTypeUnitMission;
    }

    /**
     * @param int $idTypeUnitMission
     */
    public function setIdTypeUnitMission($idTypeUnitMission)
    {
        if(empty($this->idTypeUnitMission)) $this->idTypeUnitMission = $idTypeUnitMission;
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
     * @return void
     */
    public function save()
    {
        TypeUnitMissionBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdTypeUnitMission();
    }

    /**
     * @return void
     */
    public function delete()
    {
        TypeUnitMissionBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdTypeUnitMission($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idTypeUnitMission'=>$this->idTypeUnitMission
            ,'idTypeUnit'=>$this->idTypeUnit
            ,'idTypeMission'=>$this->idTypeMission
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(TypeUnitMissionBusiness::getFields())) as $field=>$val) {
            $method = 'set'.BaseBusiness::lowerToUpperCamelCase($field);
            $this->$method($val);
        }
    }
}