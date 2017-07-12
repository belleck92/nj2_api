<?php
/**
* Created by Manu
* Date: 2017-07-12
* Time: 12:12:19
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\CaravanBusiness;


class Caravan implements Bean {

    /**
     * @var int
     */
    protected $idCaravan;

    /**
     * @var int
     */
    protected $idPlayer = 0;

    /**
     * @var int
     */
    protected $idTypeRessource = 0;

    /**
     * @var int
     */
    protected $qty = 0;

    /**
     * @var int
     */
    protected $turnsLeft = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * @return int
     */
    public function getIdCaravan()
    {
        return $this->idCaravan;
    }

    /**
     * @param int $idCaravan
     */
    public function setIdCaravan($idCaravan)
    {
        if(empty($this->idCaravan)) $this->idCaravan = $idCaravan;
    }
    
    /**
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
     * @return int
     */
    public function getIdTypeRessource()
    {
        return $this->idTypeRessource;
    }

    /**
     * @param int $idTypeRessource
     */
    public function setIdTypeRessource($idTypeRessource)
    {
        $this->idTypeRessource = $idTypeRessource;
    }
    
    /**
     * Incremente $this->idTypeRessource de $increment
     * @param int $increment
     */
    public function incrIdTypeRessource($increment) {
        $this->setIdTypeRessource($this->getIdTypeRessource() + $increment);
    }
    
    /**
     * @return int
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * @param int $qty
     */
    public function setQty($qty)
    {
        $this->qty = $qty;
    }
    
    /**
     * Incremente $this->qty de $increment
     * @param int $increment
     */
    public function incrQty($increment) {
        $this->setQty($this->getQty() + $increment);
    }
    
    /**
     * @return int
     */
    public function getTurnsLeft()
    {
        return $this->turnsLeft;
    }

    /**
     * @param int $turnsLeft
     */
    public function setTurnsLeft($turnsLeft)
    {
        $this->turnsLeft = $turnsLeft;
    }
    
    /**
     * Incremente $this->turnsLeft de $increment
     * @param int $increment
     */
    public function incrTurnsLeft($increment) {
        $this->setTurnsLeft($this->getTurnsLeft() + $increment);
    }
    
    /**
     * @return void
     */
    public function save()
    {
        CaravanBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdCaravan();
    }

    /**
     * @return void
     */
    public function delete()
    {
        CaravanBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdCaravan($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idCaravan'=>$this->idCaravan
            ,'idPlayer'=>$this->idPlayer
            ,'idTypeRessource'=>$this->idTypeRessource
            ,'qty'=>$this->qty
            ,'turnsLeft'=>$this->turnsLeft
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(CaravanBusiness::getFields())) as $field=>$val) {
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