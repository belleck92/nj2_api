<?php
/**
* Created by Manu
* Date: 2017-07-12
* Time: 12:12:19
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\ProbaResourceClimateBusiness;
use Fr\Nj2\Api\models\store\TypeClimateStore;
use Fr\Nj2\Api\models\store\TypeResourceStore;


class ProbaResourceClimate implements Bean {

    /**
     * @var int
     */
    protected $idProbaResourceClimate;

    /**
     * @var int
     */
    protected $idTypeResource = 0;

    /**
     * @var int
     */
    protected $idTypeClimate = 0;

    /**
     * @var int
     */
    protected $proba = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * @return int
     */
    public function getIdProbaResourceClimate()
    {
        return $this->idProbaResourceClimate;
    }

    /**
     * @param int $idProbaResourceClimate
     */
    public function setIdProbaResourceClimate($idProbaResourceClimate)
    {
        if(empty($this->idProbaResourceClimate)) $this->idProbaResourceClimate = $idProbaResourceClimate;
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
    public function getIdTypeClimate()
    {
        return $this->idTypeClimate;
    }

    /**
     * @param int $idTypeClimate
     */
    public function setIdTypeClimate($idTypeClimate)
    {
        $this->idTypeClimate = $idTypeClimate;
    }
    
    /**
     * Incremente $this->idTypeClimate de $increment
     * @param int $increment
     */
    public function incrIdTypeClimate($increment) {
        $this->setIdTypeClimate($this->getIdTypeClimate() + $increment);
    }
    
    /**
     * @return int
     */
    public function getProba()
    {
        return $this->proba;
    }

    /**
     * @param int $proba
     */
    public function setProba($proba)
    {
        $this->proba = $proba;
    }
    
    /**
     * Incremente $this->proba de $increment
     * @param int $increment
     */
    public function incrProba($increment) {
        $this->setProba($this->getProba() + $increment);
    }
    

    /**
     * Renvoie le typeClimate lié
     * @return extended\TypeClimate
     */
    public function getTypeClimate()
    {
        return TypeClimateStore::getById($this->getIdTypeClimate());
    }

    /**
     * Links the idTypeClimate of the TypeClimate object
     * @param int $idTypeClimate
    */
    public function setIdTypeClimateRef(&$idTypeClimate)
    {
        $this->idTypeClimate = $idTypeClimate;
    }


    /**
     * Renvoie le typeResource lié
     * @return extended\TypeResource
     */
    public function getTypeResource()
    {
        return TypeResourceStore::getById($this->getIdTypeResource());
    }

    /**
     * Links the idTypeResource of the TypeResource object
     * @param int $idTypeResource
    */
    public function setIdTypeResourceRef(&$idTypeResource)
    {
        $this->idTypeResource = $idTypeResource;
    }

    /**
     * @return void
     */
    public function save()
    {
        ProbaResourceClimateBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdProbaResourceClimate();
    }

    /**
     * @return void
     */
    public function delete()
    {
        ProbaResourceClimateBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdProbaResourceClimate($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idProbaResourceClimate'=>$this->idProbaResourceClimate
            ,'idTypeResource'=>$this->idTypeResource
            ,'idTypeClimate'=>$this->idTypeClimate
            ,'proba'=>$this->proba
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(ProbaResourceClimateBusiness::getFields())) as $field=>$val) {
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