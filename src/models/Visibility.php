<?php
/**
* Created by Manu
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\VisibilityBusiness;


class Visibility implements Bean {

    /**
     * Primary key
     * @var int
     */
    protected $idVisibility;

    /**
     * Visibility for player
     * @var int
     */
    protected $idPlayer = 0;

    /**
     * Visibility for hexa
     * @var int
     */
    protected $idHexa = 0;

    /**
     * 0 : invisible, 1 : explored, 2 : visible
     * @var int
     */
    protected $level = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * Primary key
     * @return int
     */
    public function getIdVisibility()
    {
        return $this->idVisibility;
    }

    /**
     * @param int $idVisibility
     */
    public function setIdVisibility($idVisibility)
    {
        if(empty($this->idVisibility)) $this->idVisibility = $idVisibility;
    }
    
    /**
     * Visibility for player
     * @return int
     */
    public function getIdPlayer()
    {
        return $this->idPlayer;
    }

    /**
     * @param int $idPlayer
     */
    public function setIdPlayer($idPlayer)
    {
        $this->idPlayer = $idPlayer;
    }
    
    /**
     * Incremente $this->idPlayer de $increment
     * @param int $increment
     */
    public function incrIdPlayer($increment) {
        $this->setIdPlayer($this->getIdPlayer() + $increment);
    }
    
    /**
     * Visibility for hexa
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
     * 0 : invisible, 1 : explored, 2 : visible
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }
    
    /**
     * Incremente $this->level de $increment
     * @param int $increment
     */
    public function incrLevel($increment) {
        $this->setLevel($this->getLevel() + $increment);
    }
    
    /**
     * @return void
     */
    public function save()
    {
        VisibilityBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdVisibility();
    }

    /**
     * @return void
     */
    public function delete()
    {
        VisibilityBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdVisibility($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idVisibility'=>$this->idVisibility
            ,'idPlayer'=>$this->idPlayer
            ,'idHexa'=>$this->idHexa
            ,'level'=>$this->level
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(VisibilityBusiness::getFields())) as $field=>$val) {
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