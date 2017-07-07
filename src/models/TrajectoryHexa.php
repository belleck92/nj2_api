<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:39
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\TrajectoryHexaBusiness;


class TrajectoryHexa implements Bean {

    /**
     * @var int
     */
    private $idTrajectoryHexa;

    /**
     * @var int
     */
    private $idTrajectory = 0;

    /**
     * @var int
     */
    private $idHexa = 0;

    /**
     * @var int
     */
    private $rank = 0;

    /**
     * @return int
     */
    public function getIdTrajectoryHexa()
    {
        return $this->idTrajectoryHexa;
    }

    /**
     * @param int $idTrajectoryHexa
     */
    public function setIdTrajectoryHexa($idTrajectoryHexa)
    {
        if(empty($this->idTrajectoryHexa)) $this->idTrajectoryHexa = $idTrajectoryHexa;
    }
    
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
        $this->idTrajectory = $idTrajectory;
    }
    
    /**
     * Incremente $this->idTrajectory de $increment
     * @param int $increment
     */
    public function incrIdTrajectory($increment) {
        $this->setIdTrajectory($this->getIdTrajectory() + $increment);
    }
    
    /**
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
     * @return int
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param int $rank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }
    
    /**
     * Incremente $this->rank de $increment
     * @param int $increment
     */
    public function incrRank($increment) {
        $this->setRank($this->getRank() + $increment);
    }
    
    /**
     * @return void
     */
    public function save()
    {
        TrajectoryHexaBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdTrajectoryHexa();
    }

    /**
     * @return void
     */
    public function delete()
    {
        TrajectoryHexaBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdTrajectoryHexa($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idTrajectoryHexa'=>$this->idTrajectoryHexa
            ,'idTrajectory'=>$this->idTrajectory
            ,'idHexa'=>$this->idHexa
            ,'rank'=>$this->rank
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(TrajectoryHexaBusiness::getFields())) as $field=>$val) {
            $method = 'set'.BaseBusiness::lowerToUpperCamelCase($field);
            $this->$method($val);
        }
    }
}