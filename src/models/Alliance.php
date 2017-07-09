<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 16:56:52
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\AllianceBusiness;


class Alliance implements Bean {

    /**
     * @var int
     */
    protected $idAlliance;

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var int
     */
    protected $idLeader = 0;

    /**
     * @return int
     */
    public function getIdAlliance()
    {
        return $this->idAlliance;
    }

    /**
     * @param int $idAlliance
     */
    public function setIdAlliance($idAlliance)
    {
        if(empty($this->idAlliance)) $this->idAlliance = $idAlliance;
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
     * @return int
     */
    public function getIdLeader()
    {
        return $this->idLeader;
    }

    /**
     * @param int $idLeader
     */
    public function setIdLeader($idLeader)
    {
        $this->idLeader = $idLeader;
    }
    
    /**
     * Incremente $this->idLeader de $increment
     * @param int $increment
     */
    public function incrIdLeader($increment) {
        $this->setIdLeader($this->getIdLeader() + $increment);
    }
    
    /**
     * @return void
     */
    public function save()
    {
        AllianceBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdAlliance();
    }

    /**
     * @return void
     */
    public function delete()
    {
        AllianceBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdAlliance($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idAlliance'=>$this->idAlliance
            ,'name'=>$this->name
            ,'idLeader'=>$this->idLeader
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(AllianceBusiness::getFields())) as $field=>$val) {
            $method = 'set'.BaseBusiness::lowerToUpperCamelCase($field);
            $this->$method($val);
        }
    }
}