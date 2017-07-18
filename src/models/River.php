<?php
/**
* Created by Manu
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\RiverBusiness;
use Fr\Nj2\Api\models\store\HexaStore;


class River implements Bean {

    /**
     * @var int
     */
    protected $idRiver;

    /**
     * @var int
     */
    protected $idHexa = 0;

    /**
     * @var int
     */
    protected $side = 0;

    /**
     * @var bool
     */
    protected $ford = false;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * @return int
     */
    public function getIdRiver()
    {
        return $this->idRiver;
    }

    /**
     * @param int $idRiver
     */
    public function setIdRiver($idRiver)
    {
        if(empty($this->idRiver)) $this->idRiver = $idRiver;
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
    public function getSide()
    {
        return $this->side;
    }

    /**
     * @param int $side
     */
    public function setSide($side)
    {
        $this->side = $side;
    }
    
    /**
     * Incremente $this->side de $increment
     * @param int $increment
     */
    public function incrSide($increment) {
        $this->setSide($this->getSide() + $increment);
    }
    
    /**
     * @return bool
     */
    public function getFord()
    {
        return $this->ford;
    }

    /**
     * @param bool $ford
     */
    public function setFord($ford)
    {
        $this->ford = $ford;
    }
    

    /**
     * Renvoie le hexa lié
     * @return extended\Hexa
     */
    public function getHexa()
    {
        return HexaStore::getById($this->getIdHexa());
    }

    /**
     * Links the idHexa of the Hexa object
     * @param int $idHexa
    */
    public function setIdHexaRef(&$idHexa)
    {
        $this->idHexa = $idHexa;
    }

    /**
     * @return void
     */
    public function save()
    {
        RiverBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdRiver();
    }

    /**
     * @return void
     */
    public function delete()
    {
        RiverBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdRiver($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idRiver'=>$this->idRiver
            ,'idHexa'=>$this->idHexa
            ,'side'=>$this->side
            ,'ford'=>$this->ford
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(RiverBusiness::getFields())) as $field=>$val) {
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