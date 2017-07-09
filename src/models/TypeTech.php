<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 16:56:52
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\TypeTechBusiness;


class TypeTech implements Bean {

    /**
     * @var int
     */
    protected $idTypeTech;

    /**
     * @var int
     */
    protected $idTechCategory = 0;

    /**
     * @var int
     */
    protected $idEra = 0;

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
     * @var int
     */
    protected $idTechCategoryNeeded = 0;

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
        if(empty($this->idTypeTech)) $this->idTypeTech = $idTypeTech;
    }
    
    /**
     * @return int
     */
    public function getIdTechCategory()
    {
        return $this->idTechCategory;
    }

    /**
     * @param int $idTechCategory
     */
    public function setIdTechCategory($idTechCategory)
    {
        $this->idTechCategory = $idTechCategory;
    }
    
    /**
     * Incremente $this->idTechCategory de $increment
     * @param int $increment
     */
    public function incrIdTechCategory($increment) {
        $this->setIdTechCategory($this->getIdTechCategory() + $increment);
    }
    
    /**
     * @return int
     */
    public function getIdEra()
    {
        return $this->idEra;
    }

    /**
     * @param int $idEra
     */
    public function setIdEra($idEra)
    {
        $this->idEra = $idEra;
    }
    
    /**
     * Incremente $this->idEra de $increment
     * @param int $increment
     */
    public function incrIdEra($increment) {
        $this->setIdEra($this->getIdEra() + $increment);
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
     * @return int
     */
    public function getIdTechCategoryNeeded()
    {
        return $this->idTechCategoryNeeded;
    }

    /**
     * @param int $idTechCategoryNeeded
     */
    public function setIdTechCategoryNeeded($idTechCategoryNeeded)
    {
        $this->idTechCategoryNeeded = $idTechCategoryNeeded;
    }
    
    /**
     * Incremente $this->idTechCategoryNeeded de $increment
     * @param int $increment
     */
    public function incrIdTechCategoryNeeded($increment) {
        $this->setIdTechCategoryNeeded($this->getIdTechCategoryNeeded() + $increment);
    }
    
    /**
     * @return void
     */
    public function save()
    {
        TypeTechBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdTypeTech();
    }

    /**
     * @return void
     */
    public function delete()
    {
        TypeTechBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdTypeTech($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idTypeTech'=>$this->idTypeTech
            ,'idTechCategory'=>$this->idTechCategory
            ,'idEra'=>$this->idEra
            ,'name'=>$this->name
            ,'description'=>$this->description
            ,'fctId'=>$this->fctId
            ,'idTechCategoryNeeded'=>$this->idTechCategoryNeeded
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(TypeTechBusiness::getFields())) as $field=>$val) {
            $method = 'set'.BaseBusiness::lowerToUpperCamelCase($field);
            $this->$method($val);
        }
    }
}