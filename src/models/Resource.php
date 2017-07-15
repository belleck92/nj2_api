<?php
/**
* Created by Manu
* Date: 2017-07-14
* Time: 11:44:36
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\ResourceBusiness;
use Fr\Nj2\Api\models\store\TypeResourceStore;
use Fr\Nj2\Api\models\store\HexaStore;


class Resource implements Bean {

    /**
     * @var int
     */
    protected $idResource;

    /**
     * @var int
     */
    protected $idHexa = 0;

    /**
     * @var int
     */
    protected $idTypeResource = 0;

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
    public function getIdResource()
    {
        return $this->idResource;
    }

    /**
     * @param int $idResource
     */
    public function setIdResource($idResource)
    {
        if(empty($this->idResource)) $this->idResource = $idResource;
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
        ResourceBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdResource();
    }

    /**
     * @return void
     */
    public function delete()
    {
        ResourceBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdResource($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idResource'=>$this->idResource
            ,'idHexa'=>$this->idHexa
            ,'idTypeResource'=>$this->idTypeResource
            ,'fctId'=>$this->fctId
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(ResourceBusiness::getFields())) as $field=>$val) {
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