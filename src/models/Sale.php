<?php
/**
* Created by Manu
* Date: 2017-07-15
* Time: 12:29:12
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\SaleBusiness;


class Sale implements Bean {

    /**
     * @var int
     */
    protected $idSale;

    /**
     * @var int
     */
    protected $idHexa = 0;

    /**
     * @var int
     */
    protected $price = 0;

    /**
     * @var int
     */
    protected $idTypeResource = 0;

    /**
     * @var int
     */
    protected $qty = 0;

    /**
     * @var int
     */
    protected $idExpert = 0;

    /**
     * @var int
     */
    protected $idTypeTech = 0;

    /**
     * @var bool
     */
    protected $citySale = false;

    /**
     * @var int
     */
    protected $idUnit = 0;

    /**
     * @var int
     */
    protected $idSpy = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * @return int
     */
    public function getIdSale()
    {
        return $this->idSale;
    }

    /**
     * @param int $idSale
     */
    public function setIdSale($idSale)
    {
        if(empty($this->idSale)) $this->idSale = $idSale;
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
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
    
    /**
     * Incremente $this->price de $increment
     * @param int $increment
     */
    public function incrPrice($increment) {
        $this->setPrice($this->getPrice() + $increment);
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
    public function getIdExpert()
    {
        return $this->idExpert;
    }

    /**
     * @param int $idExpert
     */
    public function setIdExpert($idExpert)
    {
        $this->idExpert = $idExpert;
    }
    
    /**
     * Incremente $this->idExpert de $increment
     * @param int $increment
     */
    public function incrIdExpert($increment) {
        $this->setIdExpert($this->getIdExpert() + $increment);
    }
    
    /**
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
     * @return bool
     */
    public function getCitySale()
    {
        return $this->citySale;
    }

    /**
     * @param bool $citySale
     */
    public function setCitySale($citySale)
    {
        $this->citySale = $citySale;
    }
    
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
        $this->idUnit = $idUnit;
    }
    
    /**
     * Incremente $this->idUnit de $increment
     * @param int $increment
     */
    public function incrIdUnit($increment) {
        $this->setIdUnit($this->getIdUnit() + $increment);
    }
    
    /**
     * @return int
     */
    public function getIdSpy()
    {
        return $this->idSpy;
    }

    /**
     * @param int $idSpy
     */
    public function setIdSpy($idSpy)
    {
        $this->idSpy = $idSpy;
    }
    
    /**
     * Incremente $this->idSpy de $increment
     * @param int $increment
     */
    public function incrIdSpy($increment) {
        $this->setIdSpy($this->getIdSpy() + $increment);
    }
    
    /**
     * @return void
     */
    public function save()
    {
        SaleBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdSale();
    }

    /**
     * @return void
     */
    public function delete()
    {
        SaleBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdSale($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idSale'=>$this->idSale
            ,'idHexa'=>$this->idHexa
            ,'price'=>$this->price
            ,'idTypeResource'=>$this->idTypeResource
            ,'qty'=>$this->qty
            ,'idExpert'=>$this->idExpert
            ,'idTypeTech'=>$this->idTypeTech
            ,'citySale'=>$this->citySale
            ,'idUnit'=>$this->idUnit
            ,'idSpy'=>$this->idSpy
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(SaleBusiness::getFields())) as $field=>$val) {
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