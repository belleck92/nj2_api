<?php
/**
* Created by Manu
* Date: 2017-07-11
* Time: 17:29:12
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\TypeTreatyBusiness;


class TypeTreaty implements Bean {

    /**
     * @var int
     */
    protected $idTypeTreaty;

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
     * @return int
     */
    public function getIdTypeTreaty()
    {
        return $this->idTypeTreaty;
    }

    /**
     * @param int $idTypeTreaty
     */
    public function setIdTypeTreaty($idTypeTreaty)
    {
        if(empty($this->idTypeTreaty)) $this->idTypeTreaty = $idTypeTreaty;
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
        TypeTreatyBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdTypeTreaty();
    }

    /**
     * @return void
     */
    public function delete()
    {
        TypeTreatyBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdTypeTreaty($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idTypeTreaty'=>$this->idTypeTreaty
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
        foreach (array_intersect_key($data,array_flip(TypeTreatyBusiness::getFields())) as $field=>$val) {
            $method = 'set'.BaseBusiness::lowerToUpperCamelCase($field);
            $this->$method($val);
        }
    }
}