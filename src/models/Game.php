<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:39
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\GameBusiness;


class Game implements Bean {

    /**
     * @var int
     */
    private $idGame;

    /**
     * @var int
     */
    private $currentTurn = 0;

    /**
     * @var int
     */
    private $maxTurns = 0;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var bool
     */
    private $started = false;

    /**
     * @return int
     */
    public function getIdGame()
    {
        return $this->idGame;
    }

    /**
     * @param int $idGame
     */
    public function setIdGame($idGame)
    {
        if(empty($this->idGame)) $this->idGame = $idGame;
    }
    
    /**
     * @return int
     */
    public function getCurrentTurn()
    {
        return $this->currentTurn;
    }

    /**
     * @param int $currentTurn
     */
    public function setCurrentTurn($currentTurn)
    {
        $this->currentTurn = $currentTurn;
    }
    
    /**
     * Incremente $this->currentTurn de $increment
     * @param int $increment
     */
    public function incrCurrentTurn($increment) {
        $this->setCurrentTurn($this->getCurrentTurn() + $increment);
    }
    
    /**
     * @return int
     */
    public function getMaxTurns()
    {
        return $this->maxTurns;
    }

    /**
     * @param int $maxTurns
     */
    public function setMaxTurns($maxTurns)
    {
        $this->maxTurns = $maxTurns;
    }
    
    /**
     * Incremente $this->maxTurns de $increment
     * @param int $increment
     */
    public function incrMaxTurns($increment) {
        $this->setMaxTurns($this->getMaxTurns() + $increment);
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
     * @return bool
     */
    public function getStarted()
    {
        return $this->started;
    }

    /**
     * @param bool $started
     */
    public function setStarted($started)
    {
        $this->started = $started;
    }
    
    /**
     * @return void
     */
    public function save()
    {
        GameBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdGame();
    }

    /**
     * @return void
     */
    public function delete()
    {
        GameBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdGame($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idGame'=>$this->idGame
            ,'currentTurn'=>$this->currentTurn
            ,'maxTurns'=>$this->maxTurns
            ,'name'=>$this->name
            ,'started'=>$this->started
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(GameBusiness::getFields())) as $field=>$val) {
            $method = 'set'.BaseBusiness::lowerToUpperCamelCase($field);
            $this->$method($val);
        }
    }
}