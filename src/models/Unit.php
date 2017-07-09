<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 16:56:52
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\UnitBusiness;


class Unit implements Bean {

    /**
     * @var int
     */
    protected $idUnit;

    /**
     * @var int
     */
    protected $idTypeUnit = 0;

    /**
     * @var int
     */
    protected $idHq = 0;

    /**
     * @var int
     */
    protected $idHexa = 0;

    /**
     * @var int
     */
    protected $buildingTurnsLeft = 0;

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $morale = '';

    /**
     * @var int
     */
    protected $xp = 0;

    /**
     * @return int
     */
    public function getIdUnit()
    {
        return $this->idUnit;
    }

    /**
     * @param int $idUnit
     */
    public function setIdUnit($idUnit)
    {
        if(empty($this->idUnit)) $this->idUnit = $idUnit;
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
    public function getIdHq()
    {
        return $this->idHq;
    }

    /**
     * @param int $idHq
     */
    public function setIdHq($idHq)
    {
        $this->idHq = $idHq;
    }
    
    /**
     * Incremente $this->idHq de $increment
     * @param int $increment
     */
    public function incrIdHq($increment) {
        $this->setIdHq($this->getIdHq() + $increment);
    }
    
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
    public function getMorale()
    {
        return $this->morale;
    }

    /**
     * @param string $morale
     */
    public function setMorale($morale)
    {
        $this->morale = $morale;
    }
    
    /**
     * @return int
     */
    public function getXp()
    {
        return $this->xp;
    }

    /**
     * @param int $xp
     */
    public function setXp($xp)
    {
        $this->xp = $xp;
    }
    
    /**
     * Incremente $this->xp de $increment
     * @param int $increment
     */
    public function incrXp($increment) {
        $this->setXp($this->getXp() + $increment);
    }
    
    /**
     * @return void
     */
    public function save()
    {
        UnitBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdUnit();
    }

    /**
     * @return void
     */
    public function delete()
    {
        UnitBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdUnit($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idUnit'=>$this->idUnit
            ,'idTypeUnit'=>$this->idTypeUnit
            ,'idHq'=>$this->idHq
            ,'idHexa'=>$this->idHexa
            ,'buildingTurnsLeft'=>$this->buildingTurnsLeft
            ,'name'=>$this->name
            ,'morale'=>$this->morale
            ,'xp'=>$this->xp
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(UnitBusiness::getFields())) as $field=>$val) {
            $method = 'set'.BaseBusiness::lowerToUpperCamelCase($field);
            $this->$method($val);
        }
    }
}