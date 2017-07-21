<?php
/**
* Created by Manu
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\ParameterBusiness;


class Parameter implements Bean {

    /**
     * Primary key
     * @var int
     */
    protected $idParameter;

    /**
     * 
     * @var int
     */
    protected $value = 0;

    /**
     * 
     * @var string
     */
    protected $description = '';

    /**
     * 
     * @var string
     */
    protected $fctId = '';

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * Primary key
     * @return int
     */
    public function getIdParameter()
    {
        return $this->idParameter;
    }

    /**
     * @param int $idParameter
     */
    public function setIdParameter($idParameter)
    {
        if(empty($this->idParameter)) $this->idParameter = $idParameter;
    }
    
    /**
     * 
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
    
    /**
     * Incremente $this->value de $increment
     * @param int $increment
     */
    public function incrValue($increment) {
        $this->setValue($this->getValue() + $increment);
    }
    
    /**
     * 
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
     * 
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
        ParameterBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdParameter();
    }

    /**
     * @return void
     */
    public function delete()
    {
        ParameterBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdParameter($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idParameter'=>$this->idParameter
            ,'value'=>$this->value
            ,'description'=>$this->description
            ,'fctId'=>$this->fctId
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(ParameterBusiness::getFields())) as $field=>$val) {
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