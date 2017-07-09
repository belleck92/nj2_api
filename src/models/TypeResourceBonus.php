<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 15:09:50
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\TypeResourceBonusBusiness;


class TypeResourceBonus implements Bean {

    /**
     * @var int
     */
    private $idTypeResourceBonus;

    /**
     * @var int
     */
    private $idTypeResource = 0;

    /**
     * @var int
     */
    private $idBonus = 0;

    /**
     * @var int
     */
    private $era = 0;

    /**
     * @return int
     */
    public function getIdTypeResourceBonus()
    {
        return $this->idTypeResourceBonus;
    }

    /**
     * @param int $idTypeResourceBonus
     */
    public function setIdTypeResourceBonus($idTypeResourceBonus)
    {
        if(empty($this->idTypeResourceBonus)) $this->idTypeResourceBonus = $idTypeResourceBonus;
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
     * @return void
     */
    public function save()
    {
        TypeResourceBonusBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdTypeResourceBonus();
    }

    /**
     * @return void
     */
    public function delete()
    {
        TypeResourceBonusBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdTypeResourceBonus($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idTypeResourceBonus'=>$this->idTypeResourceBonus
            ,'idTypeResource'=>$this->idTypeResource
            ,'idBonus'=>$this->idBonus
            ,'era'=>$this->era
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(TypeResourceBonusBusiness::getFields())) as $field=>$val) {
            $method = 'set'.BaseBusiness::lowerToUpperCamelCase($field);
            $this->$method($val);
        }
    }
}