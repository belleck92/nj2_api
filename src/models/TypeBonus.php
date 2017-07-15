<?php
/**
* Created by Manu
* Date: 2017-07-15
* Time: 12:29:12
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\TypeBonusBusiness;


class TypeBonus implements Bean {

    /**
     * @var int
     */
    protected $idTypeBonus;

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string
     */
    protected $fctId = '';

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * @return int
     */
    public function getIdTypeBonus()
    {
        return $this->idTypeBonus;
    }

    /**
     * @param int $idTypeBonus
     */
    public function setIdTypeBonus($idTypeBonus)
    {
        if(empty($this->idTypeBonus)) $this->idTypeBonus = $idTypeBonus;
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
        TypeBonusBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdTypeBonus();
    }

    /**
     * @return void
     */
    public function delete()
    {
        TypeBonusBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdTypeBonus($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idTypeBonus'=>$this->idTypeBonus
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
        foreach (array_intersect_key($data,array_flip(TypeBonusBusiness::getFields())) as $field=>$val) {
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