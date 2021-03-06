<?php
/**
* Created by Manu
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\TypeHqBusiness;


class TypeHq implements Bean {

    /**
     * Primary key
     * @var int
     */
    protected $idTypeHq;

    /**
     * 
     * @var string
     */
    protected $name = '';

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
    public function getIdTypeHq()
    {
        return $this->idTypeHq;
    }

    /**
     * @param int $idTypeHq
     */
    public function setIdTypeHq($idTypeHq)
    {
        if(empty($this->idTypeHq)) $this->idTypeHq = $idTypeHq;
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
        TypeHqBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdTypeHq();
    }

    /**
     * @return void
     */
    public function delete()
    {
        TypeHqBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdTypeHq($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idTypeHq'=>$this->idTypeHq
            ,'name'=>$this->name
            ,'description'=>$this->description
            ,'fctId'=>$this->fctId
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(TypeHqBusiness::getFields())) as $field=>$val) {
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