<?php
/**
* Created by Manu
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\HqBusiness;


class Hq implements Bean {

    /**
     * Primary key
     * @var int
     */
    protected $idHq;

    /**
     * 
     * @var int
     */
    protected $idHexa = 0;

    /**
     * 
     * @var int
     */
    protected $idPlayer = 0;

    /**
     * Id of the mission type
     * @var int
     */
    protected $idTypeMission = 0;

    /**
     * Type of hq (terrestrial, aerial, naval)
     * @var int
     */
    protected $idTypeHq = 0;

    /**
     * Id of the target of the mission
     * @var int
     */
    protected $idTarget = 0;

    /**
     * 
     * @var string
     */
    protected $name = '';

    /**
     * Level of the hq
     * @var int
     */
    protected $level = 0;

    /**
     * 
     * @var int
     */
    protected $capop = 0;

    /**
     * Bonus usable by the palace
     * @var bool
     */
    protected $isPalaceBonus = false;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * Primary key
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
        if(empty($this->idHq)) $this->idHq = $idHq;
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
     * Id of the mission type
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
     * Type of hq (terrestrial, aerial, naval)
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
     * Id of the target of the mission
     * @return int
     */
    public function getIdTarget()
    {
        return $this->idTarget;
    }

    /**
     * @param int $idTarget
     */
    public function setIdTarget($idTarget)
    {
        $this->idTarget = $idTarget;
    }
    
    /**
     * Incremente $this->idTarget de $increment
     * @param int $increment
     */
    public function incrIdTarget($increment) {
        $this->setIdTarget($this->getIdTarget() + $increment);
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
     * Level of the hq
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }
    
    /**
     * Incremente $this->level de $increment
     * @param int $increment
     */
    public function incrLevel($increment) {
        $this->setLevel($this->getLevel() + $increment);
    }
    
    /**
     * 
     * @return int
     */
    public function getCapop()
    {
        return $this->capop;
    }

    /**
     * @param int $capop
     */
    public function setCapop($capop)
    {
        $this->capop = $capop;
    }
    
    /**
     * Incremente $this->capop de $increment
     * @param int $increment
     */
    public function incrCapop($increment) {
        $this->setCapop($this->getCapop() + $increment);
    }
    
    /**
     * Bonus usable by the palace
     * @return bool
     */
    public function getIsPalaceBonus()
    {
        return $this->isPalaceBonus;
    }

    /**
     * @param bool $isPalaceBonus
     */
    public function setIsPalaceBonus($isPalaceBonus)
    {
        $this->isPalaceBonus = $isPalaceBonus;
    }
    
    /**
     * @return void
     */
    public function save()
    {
        HqBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdHq();
    }

    /**
     * @return void
     */
    public function delete()
    {
        HqBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdHq($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idHq'=>$this->idHq
            ,'idHexa'=>$this->idHexa
            ,'idPlayer'=>$this->idPlayer
            ,'idTypeMission'=>$this->idTypeMission
            ,'idTypeHq'=>$this->idTypeHq
            ,'idTarget'=>$this->idTarget
            ,'name'=>$this->name
            ,'level'=>$this->level
            ,'capop'=>$this->capop
            ,'isPalaceBonus'=>$this->isPalaceBonus
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(HqBusiness::getFields())) as $field=>$val) {
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