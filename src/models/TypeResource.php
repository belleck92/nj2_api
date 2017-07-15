<?php
/**
* Created by Manu
* Date: 2017-07-15
* Time: 12:29:12
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\TypeResourceBusiness;
use Fr\Nj2\Api\models\collection\ProbaResourceClimateCollection;
use Fr\Nj2\Api\models\business\ProbaResourceClimateBusiness;
use Fr\Nj2\Api\models\extended\ProbaResourceClimate;
use Fr\Nj2\Api\models\collection\ResourceCollection;
use Fr\Nj2\Api\models\business\ResourceBusiness;
use Fr\Nj2\Api\models\extended\Resource;


class TypeResource implements Bean {

    /**
     * @var int
     */
    protected $idTypeResource;

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
     * @var ProbaResourceClimateCollection|ProbaResourceClimate[]
     */
    protected $cacheProbaResourceClimates = null;

    /**
     * @var ResourceCollection|Resource[]
     */
    protected $cacheResources = null;

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
        if(empty($this->idTypeResource)) $this->idTypeResource = $idTypeResource;
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
     * Remet à null le cache des probaResourceClimates liés à this
     */
    public function resetCacheProbaResourceClimates() {
        $this->cacheProbaResourceClimates = null;
    }

    /**
    * Force la collection de probaResourceClimates de this
    * @param ProbaResourceClimateCollection $probaResourceClimates
    */
    public function setProbaResourceClimates(ProbaResourceClimateCollection $probaResourceClimates)
    {
        $this->cacheProbaResourceClimates = $probaResourceClimates;
    }

    /**
     * Renvoie les probaResourceClimates liés à ce TypeResource
     * @return ProbaResourceClimateCollection|ProbaResourceClimate[]
     */
    public function getProbaResourceClimates() {
        if(is_null($this->cacheProbaResourceClimates)) {
            $this->cacheProbaResourceClimates = ProbaResourceClimateBusiness::getByTypeResource($this);
            $this->cacheProbaResourceClimates->store();
        }
        return $this->cacheProbaResourceClimates;
    }

    /**
     * Crée un probaResourceClimate lié à ce TypeResource
     * @return extended\ProbaResourceClimate
     */
    public function createProbaResourceClimate(){
        $probaResourceClimate = new extended\ProbaResourceClimate();
        $probaResourceClimate->setIdTypeResourceRef($this->idTypeResource);
        return $probaResourceClimate;
    }

    /**
     * Remet à null le cache des resources liés à this
     */
    public function resetCacheResources() {
        $this->cacheResources = null;
    }

    /**
    * Force la collection de resources de this
    * @param ResourceCollection $resources
    */
    public function setResources(ResourceCollection $resources)
    {
        $this->cacheResources = $resources;
    }

    /**
     * Renvoie les resources liés à ce TypeResource
     * @return ResourceCollection|Resource[]
     */
    public function getResources() {
        if(is_null($this->cacheResources)) {
            $this->cacheResources = ResourceBusiness::getByTypeResource($this);
            $this->cacheResources->store();
        }
        return $this->cacheResources;
    }

    /**
     * Crée un resource lié à ce TypeResource
     * @return extended\Resource
     */
    public function createResource(){
        $resource = new extended\Resource();
        $resource->setIdTypeResourceRef($this->idTypeResource);
        return $resource;
    }

    /**
     * @return void
     */
    public function save()
    {
        TypeResourceBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdTypeResource();
    }

    /**
     * @return void
     */
    public function delete()
    {
        TypeResourceBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdTypeResource($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idTypeResource'=>$this->idTypeResource
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
        foreach (array_intersect_key($data,array_flip(TypeResourceBusiness::getFields())) as $field=>$val) {
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