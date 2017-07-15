<?php
/**
* Created by Manu
* Date: 2017-07-15
* Time: 12:29:12
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\PalaceBonusBusiness;


class PalaceBonus implements Bean {

    /**
     * @var int
     */
    protected $idPalaceBonus;

    /**
     * @var int
     */
    protected $idPlayer = 0;

    /**
     * @var int
     */
    protected $idTypeBonus = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * @return int
     */
    public function getIdPalaceBonus()
    {
        return $this->idPalaceBonus;
    }

    /**
     * @param int $idPalaceBonus
     */
    public function setIdPalaceBonus($idPalaceBonus)
    {
        if(empty($this->idPalaceBonus)) $this->idPalaceBonus = $idPalaceBonus;
    }
    
    /**
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
     * @return int
     */
    public function getIdTypeBonus()
    {
        return $this->idTypeBonus;
    }

    /**
     * @param int $idTypeBonus
     */
    public function setIdTypeBonus($idTypeBonus)
    {
        $this->idTypeBonus = $idTypeBonus;
    }
    
    /**
     * Incremente $this->idTypeBonus de $increment
     * @param int $increment
     */
    public function incrIdTypeBonus($increment) {
        $this->setIdTypeBonus($this->getIdTypeBonus() + $increment);
    }
    
    /**
     * @return void
     */
    public function save()
    {
        PalaceBonusBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdPalaceBonus();
    }

    /**
     * @return void
     */
    public function delete()
    {
        PalaceBonusBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdPalaceBonus($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idPalaceBonus'=>$this->idPalaceBonus
            ,'idPlayer'=>$this->idPlayer
            ,'idTypeBonus'=>$this->idTypeBonus
        ];
    }

    /**
     * @param array $data
     */
    public function edit($data)
    {
        foreach (array_intersect_key($data,array_flip(PalaceBonusBusiness::getFields())) as $field=>$val) {
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