<?php
/**
* Created by Manu
* Date: 2017-07-11
* Time: 17:29:12
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\TypeResourceBusiness;
use Fr\Nj2\Api\models\collection\ProbaResourceClimateCollection;
use Fr\Nj2\Api\models\business\ProbaResourceClimateBusiness;
use Fr\Nj2\Api\models\extended\ProbaResourceClimate;


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
     * @var ProbaResourceClimateCollection|ProbaResourceClimate[]
     */
    protected $cacheProbaResourceClimates = null;

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
        $probaResourceClimate->setIdTypeResource($this->getIdTypeResource());
        return $probaResourceClimate;
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
}