<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 15:09:50
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\TypeClimateBusiness;


class TypeClimate implements Bean {

    /**
     * @var int
     */
    private $idTypeClimate;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var string
     */
    private $fctId = '';

    /**
     * @var int
     */
    private $food = 0;

    /**
     * @var int
     */
    private $defenseBonus = 0;

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
        if(empty($this->idTypeClimate)) $this->idTypeClimate = $idTypeClimate;
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
    public function getFood()
    {
        return $this->food;
    }

    /**
     * @param int $food
     */
    public function setFood($food)
    {
        $this->food = $food;
    }
    
    /**
     * Incremente $this->food de $increment
     * @param int $increment
     */
    public function incrFood($increment) {
        $this->setFood($this->getFood() + $increment);
    }
    
    /**
     * @return int
     */
    public function getDefenseBonus()
    {
        return $this->defenseBonus;
    }

    /**
     * @param int $defenseBonus
     */
    public function setDefenseBonus($defenseBonus)
    {
        $this->defenseBonus = $defenseBonus;
    }
    
    /**
     * Incremente $this->defenseBonus de $increment
     * @param int $increment
     */
    public function incrDefenseBonus($increment) {
        $this->setDefenseBonus($this->getDefenseBonus() + $increment);
    }
    
    /**
     * @return void
     */
    public function save()
    {
        TypeClimateBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdTypeClimate();
    }

    /**
     * @return void
     */
    public function delete()
    {
        TypeClimateBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdTypeClimate($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idTypeClimate'=>$this->idTypeClimate
            ,'name'=>$this->name
            ,'description'=>$this->description
            ,'fctId'=>$this->fctId
            ,'food'=>$this->food
            ,'defenseBonus'=>$this->defenseBonus
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(TypeClimateBusiness::getFields())) as $field=>$val) {
            $method = 'set'.BaseBusiness::lowerToUpperCamelCase($field);
            $this->$method($val);
        }
    }
}