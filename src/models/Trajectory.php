<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 15:09:50
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\TrajectoryBusiness;


class Trajectory implements Bean {

    /**
     * @var int
     */
    private $idTrajectory;

    /**
     * @var int
     */
    private $idHq = 0;

    /**
     * @var int
     */
    private $idSpy = 0;

    /**
     * @var int
     */
    private $idCaravan = 0;

    /**
     * @var int
     */
    private $idExpert = 0;

    /**
     * @return int
     */
    public function getIdTrajectory()
    {
        return $this->idTrajectory;
    }

    /**
     * @param int $idTrajectory
     */
    public function setIdTrajectory($idTrajectory)
    {
        if(empty($this->idTrajectory)) $this->idTrajectory = $idTrajectory;
    }
    
    /**
     * @return int
     */
    public function getIdHq()
    {
        return $this->idHq;
    }

    /**
     * @param int $idHq
     */
    public function setIdHq($idHq)
    {
        $this->idHq = $idHq;
    }
    
    /**
     * Incremente $this->idHq de $increment
     * @param int $increment
     */
    public function incrIdHq($increment) {
        $this->setIdHq($this->getIdHq() + $increment);
    }
    
    /**
     * @return int
     */
    public function getIdSpy()
    {
        return $this->idSpy;
    }

    /**
     * @param int $idSpy
     */
    public function setIdSpy($idSpy)
    {
        $this->idSpy = $idSpy;
    }
    
    /**
     * Incremente $this->idSpy de $increment
     * @param int $increment
     */
    public function incrIdSpy($increment) {
        $this->setIdSpy($this->getIdSpy() + $increment);
    }
    
    /**
     * @return int
     */
    public function getIdCaravan()
    {
        return $this->idCaravan;
    }

    /**
     * @param int $idCaravan
     */
    public function setIdCaravan($idCaravan)
    {
        $this->idCaravan = $idCaravan;
    }
    
    /**
     * Incremente $this->idCaravan de $increment
     * @param int $increment
     */
    public function incrIdCaravan($increment) {
        $this->setIdCaravan($this->getIdCaravan() + $increment);
    }
    
    /**
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
        $this->idExpert = $idExpert;
    }
    
    /**
     * Incremente $this->idExpert de $increment
     * @param int $increment
     */
    public function incrIdExpert($increment) {
        $this->setIdExpert($this->getIdExpert() + $increment);
    }
    
    /**
     * @return void
     */
    public function save()
    {
        TrajectoryBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdTrajectory();
    }

    /**
     * @return void
     */
    public function delete()
    {
        TrajectoryBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdTrajectory($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idTrajectory'=>$this->idTrajectory
            ,'idHq'=>$this->idHq
            ,'idSpy'=>$this->idSpy
            ,'idCaravan'=>$this->idCaravan
            ,'idExpert'=>$this->idExpert
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(TrajectoryBusiness::getFields())) as $field=>$val) {
            $method = 'set'.BaseBusiness::lowerToUpperCamelCase($field);
            $this->$method($val);
        }
    }
}