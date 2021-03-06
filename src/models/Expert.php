<?php
/**
* Created by Manu
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\ExpertBusiness;


class Expert implements Bean {

    /**
     * Primary key
     * @var int
     */
    protected $idExpert;

    /**
     * If 0 : on sale
     * @var int
     */
    protected $idPlayer = 0;

    /**
     * 
     * @var int
     */
    protected $idBonus = 0;

    /**
     * The city where the expert works (destination). If 0 : on sale
     * @var int
     */
    protected $idHexa = 0;

    /**
     * Number of items left, depending on the role.
     * @var int
     */
    protected $itemsLeft = 0;

    /**
     * Number of turns before arrival 1=arrival at next turn resolution.
     * @var int
     */
    protected $turnsLeft = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * Primary key
     * @return int
     */
    public function getIdExpert()
    {
        return $this->idExpert;
    }

    /**
     * @param int $idExpert
     */
    public function setIdExpert($idExpert)
    {
        if(empty($this->idExpert)) $this->idExpert = $idExpert;
    }
    
    /**
     * If 0 : on sale
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
     * 
     * @return int
     */
    public function getIdBonus()
    {
        return $this->idBonus;
    }

    /**
     * @param int $idBonus
     */
    public function setIdBonus($idBonus)
    {
        $this->idBonus = $idBonus;
    }
    
    /**
     * Incremente $this->idBonus de $increment
     * @param int $increment
     */
    public function incrIdBonus($increment) {
        $this->setIdBonus($this->getIdBonus() + $increment);
    }
    
    /**
     * The city where the expert works (destination). If 0 : on sale
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
     * Number of items left, depending on the role.
     * @return int
     */
    public function getItemsLeft()
    {
        return $this->itemsLeft;
    }

    /**
     * @param int $itemsLeft
     */
    public function setItemsLeft($itemsLeft)
    {
        $this->itemsLeft = $itemsLeft;
    }
    
    /**
     * Incremente $this->itemsLeft de $increment
     * @param int $increment
     */
    public function incrItemsLeft($increment) {
        $this->setItemsLeft($this->getItemsLeft() + $increment);
    }
    
    /**
     * Number of turns before arrival 1=arrival at next turn resolution.
     * @return int
     */
    public function getTurnsLeft()
    {
        return $this->turnsLeft;
    }

    /**
     * @param int $turnsLeft
     */
    public function setTurnsLeft($turnsLeft)
    {
        $this->turnsLeft = $turnsLeft;
    }
    
    /**
     * Incremente $this->turnsLeft de $increment
     * @param int $increment
     */
    public function incrTurnsLeft($increment) {
        $this->setTurnsLeft($this->getTurnsLeft() + $increment);
    }
    
    /**
     * @return void
     */
    public function save()
    {
        ExpertBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdExpert();
    }

    /**
     * @return void
     */
    public function delete()
    {
        ExpertBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdExpert($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idExpert'=>$this->idExpert
            ,'idPlayer'=>$this->idPlayer
            ,'idBonus'=>$this->idBonus
            ,'idHexa'=>$this->idHexa
            ,'itemsLeft'=>$this->itemsLeft
            ,'turnsLeft'=>$this->turnsLeft
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(ExpertBusiness::getFields())) as $field=>$val) {
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