<?php
/**
* Created by Manu
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\TrajectoryHexaBusiness;


class TrajectoryHexa implements Bean {

    /**
     * Primary key
     * @var int
     */
    protected $idTrajectoryHexa;

    /**
     * 
     * @var int
     */
    protected $idTrajectory = 0;

    /**
     * 
     * @var int
     */
    protected $idHexa = 0;

    /**
     * Rank of the hexa in the trajectory
     * @var int
     */
    protected $rank = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * Primary key
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
     * 
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
     * 
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
     * Rank of the hexa in the trajectory
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