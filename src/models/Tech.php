<?php
/**
* Created by Manu
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\TechBusiness;


class Tech implements Bean {

    /**
     * Primary key
     * @var int
     */
    protected $idTech;

    /**
     * 
     * @var int
     */
    protected $idPlayer = 0;

    /**
     * 
     * @var int
     */
    protected $totalCost = 0;

    /**
     * Id this filed is equal to totalCost, the tech is active
     * @var int
     */
    protected $alreadyInvested = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * Primary key
     * @return int
     */
    public function getIdTech()
    {
        return $this->idTech;
    }

    /**
     * @param int $idTech
     */
    public function setIdTech($idTech)
    {
        if(empty($this->idTech)) $this->idTech = $idTech;
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
     * 
     * @return int
     */
    public function getTotalCost()
    {
        return $this->totalCost;
    }

    /**
     * @param int $totalCost
     */
    public function setTotalCost($totalCost)
    {
        $this->totalCost = $totalCost;
    }
    
    /**
     * Incremente $this->totalCost de $increment
     * @param int $increment
     */
    public function incrTotalCost($increment) {
        $this->setTotalCost($this->getTotalCost() + $increment);
    }
    
    /**
     * Id this filed is equal to totalCost, the tech is active
     * @return int
     */
    public function getAlreadyInvested()
    {
        return $this->alreadyInvested;
    }

    /**
     * @param int $alreadyInvested
     */
    public function setAlreadyInvested($alreadyInvested)
    {
        $this->alreadyInvested = $alreadyInvested;
    }
    
    /**
     * Incremente $this->alreadyInvested de $increment
     * @param int $increment
     */
    public function incrAlreadyInvested($increment) {
        $this->setAlreadyInvested($this->getAlreadyInvested() + $increment);
    }
    
    /**
     * @return void
     */
    public function save()
    {
        TechBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdTech();
    }

    /**
     * @return void
     */
    public function delete()
    {
        TechBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdTech($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idTech'=>$this->idTech
            ,'idPlayer'=>$this->idPlayer
            ,'totalCost'=>$this->totalCost
            ,'alreadyInvested'=>$this->alreadyInvested
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(TechBusiness::getFields())) as $field=>$val) {
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