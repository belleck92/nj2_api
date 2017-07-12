<?php
/**
* Created by Manu
* Date: 2017-07-12
* Time: 12:12:19
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\TreatyBusiness;


class Treaty implements Bean {

    /**
     * @var int
     */
    protected $idTreaty;

    /**
     * @var int
     */
    protected $idTypeTreaty = 0;

    /**
     * @var int
     */
    protected $idPlayer1 = 0;

    /**
     * @var int
     */
    protected $idPlayer2 = 0;

    /**
     * @var int
     */
    protected $idAlliance1 = 0;

    /**
     * @var int
     */
    protected $idAlliance2 = 0;

    /**
     * @var bool
     */
    protected $state = false;

    /**
     * @var int
     */
    protected $startingTurn = 0;

    /**
     * @var int
     */
    protected $amount = 0;

    /**
     * @var int
     */
    protected $turnsLeft = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * @return int
     */
    public function getIdTreaty()
    {
        return $this->idTreaty;
    }

    /**
     * @param int $idTreaty
     */
    public function setIdTreaty($idTreaty)
    {
        if(empty($this->idTreaty)) $this->idTreaty = $idTreaty;
    }
    
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
        $this->idTypeTreaty = $idTypeTreaty;
    }
    
    /**
     * Incremente $this->idTypeTreaty de $increment
     * @param int $increment
     */
    public function incrIdTypeTreaty($increment) {
        $this->setIdTypeTreaty($this->getIdTypeTreaty() + $increment);
    }
    
    /**
     * @return int
     */
    public function getIdPlayer1()
    {
        return $this->idPlayer1;
    }

    /**
     * @param int $idPlayer1
     */
    public function setIdPlayer1($idPlayer1)
    {
        $this->idPlayer1 = $idPlayer1;
    }
    
    /**
     * Incremente $this->idPlayer1 de $increment
     * @param int $increment
     */
    public function incrIdPlayer1($increment) {
        $this->setIdPlayer1($this->getIdPlayer1() + $increment);
    }
    
    /**
     * @return int
     */
    public function getIdPlayer2()
    {
        return $this->idPlayer2;
    }

    /**
     * @param int $idPlayer2
     */
    public function setIdPlayer2($idPlayer2)
    {
        $this->idPlayer2 = $idPlayer2;
    }
    
    /**
     * Incremente $this->idPlayer2 de $increment
     * @param int $increment
     */
    public function incrIdPlayer2($increment) {
        $this->setIdPlayer2($this->getIdPlayer2() + $increment);
    }
    
    /**
     * @return int
     */
    public function getIdAlliance1()
    {
        return $this->idAlliance1;
    }

    /**
     * @param int $idAlliance1
     */
    public function setIdAlliance1($idAlliance1)
    {
        $this->idAlliance1 = $idAlliance1;
    }
    
    /**
     * Incremente $this->idAlliance1 de $increment
     * @param int $increment
     */
    public function incrIdAlliance1($increment) {
        $this->setIdAlliance1($this->getIdAlliance1() + $increment);
    }
    
    /**
     * @return int
     */
    public function getIdAlliance2()
    {
        return $this->idAlliance2;
    }

    /**
     * @param int $idAlliance2
     */
    public function setIdAlliance2($idAlliance2)
    {
        $this->idAlliance2 = $idAlliance2;
    }
    
    /**
     * Incremente $this->idAlliance2 de $increment
     * @param int $increment
     */
    public function incrIdAlliance2($increment) {
        $this->setIdAlliance2($this->getIdAlliance2() + $increment);
    }
    
    /**
     * @return bool
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param bool $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }
    
    /**
     * @return int
     */
    public function getStartingTurn()
    {
        return $this->startingTurn;
    }

    /**
     * @param int $startingTurn
     */
    public function setStartingTurn($startingTurn)
    {
        $this->startingTurn = $startingTurn;
    }
    
    /**
     * Incremente $this->startingTurn de $increment
     * @param int $increment
     */
    public function incrStartingTurn($increment) {
        $this->setStartingTurn($this->getStartingTurn() + $increment);
    }
    
    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    
    /**
     * Incremente $this->amount de $increment
     * @param int $increment
     */
    public function incrAmount($increment) {
        $this->setAmount($this->getAmount() + $increment);
    }
    
    /**
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
        TreatyBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdTreaty();
    }

    /**
     * @return void
     */
    public function delete()
    {
        TreatyBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdTreaty($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idTreaty'=>$this->idTreaty
            ,'idTypeTreaty'=>$this->idTypeTreaty
            ,'idPlayer1'=>$this->idPlayer1
            ,'idPlayer2'=>$this->idPlayer2
            ,'idAlliance1'=>$this->idAlliance1
            ,'idAlliance2'=>$this->idAlliance2
            ,'state'=>$this->state
            ,'startingTurn'=>$this->startingTurn
            ,'amount'=>$this->amount
            ,'turnsLeft'=>$this->turnsLeft
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(TreatyBusiness::getFields())) as $field=>$val) {
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