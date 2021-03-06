<?php
/**
* Created by Manu
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\TypeTechBonusBusiness;


class TypeTechBonus implements Bean {

    /**
     * Primary key
     * @var int
     */
    protected $idTechBonus;

    /**
     * 
     * @var int
     */
    protected $idTypeTech = 0;

    /**
     * 
     * @var int
     */
    protected $idBonus = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * Primary key
     * @return int
     */
    public function getIdTechBonus()
    {
        return $this->idTechBonus;
    }

    /**
     * @param int $idTechBonus
     */
    public function setIdTechBonus($idTechBonus)
    {
        if(empty($this->idTypeTechBonus)) $this->idTechBonus = $idTechBonus;
    }
    
    /**
     * 
     * @return int
     */
    public function getIdTypeTech()
    {
        return $this->idTypeTech;
    }

    /**
     * @param int $idTypeTech
     */
    public function setIdTypeTech($idTypeTech)
    {
        $this->idTypeTech = $idTypeTech;
    }
    
    /**
     * Incremente $this->idTypeTech de $increment
     * @param int $increment
     */
    public function incrIdTypeTech($increment) {
        $this->setIdTypeTech($this->getIdTypeTech() + $increment);
    }
    
    /**
     * 
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
        $this->idBonus = $idBonus;
    }
    
    /**
     * Incremente $this->idBonus de $increment
     * @param int $increment
     */
    public function incrIdBonus($increment) {
        $this->setIdBonus($this->getIdBonus() + $increment);
    }
    
    /**
     * @return void
     */
    public function save()
    {
        TypeTechBonusBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdTechBonus();
    }

    /**
     * @return void
     */
    public function delete()
    {
        TypeTechBonusBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdTechBonus($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idTechBonus'=>$this->idTechBonus
            ,'idTypeTech'=>$this->idTypeTech
            ,'idBonus'=>$this->idBonus
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(TypeTechBonusBusiness::getFields())) as $field=>$val) {
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