<?php
/**
* Created by Manu
* Date: 2017-07-12
* Time: 12:12:19
*/

namespace Fr\Nj2\Api\models;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\TypeClimateBusiness;
use Fr\Nj2\Api\models\collection\HexaCollection;
use Fr\Nj2\Api\models\business\HexaBusiness;
use Fr\Nj2\Api\models\extended\Hexa;
use Fr\Nj2\Api\models\collection\ProbaResourceClimateCollection;
use Fr\Nj2\Api\models\business\ProbaResourceClimateBusiness;
use Fr\Nj2\Api\models\extended\ProbaResourceClimate;


class TypeClimate implements Bean {

    /**
     * @var int
     */
    protected $idTypeClimate;

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string
     */
    protected $fctId = '';

    /**
     * @var int
     */
    protected $food = 0;

    /**
     * @var int
     */
    protected $defenseBonus = 0;

    /**
     * @var bool
     */
    protected $extendedData = false;

    /**
     * @var HexaCollection|Hexa[]
     */
    protected $cacheHexas = null;

    /**
     * @var ProbaResourceClimateCollection|ProbaResourceClimate[]
     */
    protected $cacheProbaResourceClimates = null;

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
     * Remet à null le cache des hexas liés à this
     */
    public function resetCacheHexas() {
        $this->cacheHexas = null;
    }

    /**
    * Force la collection de hexas de this
    * @param HexaCollection $hexas
    */
    public function setHexas(HexaCollection $hexas)
    {
        $this->cacheHexas = $hexas;
    }

    /**
     * Renvoie les hexas liés à ce TypeClimate
     * @return HexaCollection|Hexa[]
     */
    public function getHexas() {
        if(is_null($this->cacheHexas)) {
            $this->cacheHexas = HexaBusiness::getByTypeClimate($this);
            $this->cacheHexas->store();
        }
        return $this->cacheHexas;
    }

    /**
     * Crée un hexa lié à ce TypeClimate
     * @return extended\Hexa
     */
    public function createHexa(){
        $hexa = new extended\Hexa();
        $hexa->setIdTypeClimateRef($this->idTypeClimate);
        return $hexa;
    }

    /**
     * Remet à null le cache des probaResourceClimates liés à this
     */
    public function resetCacheProbaResourceClimates() {
        $this->cacheProbaResourceClimates = null;
    }

    /**
    * Force la collection de probaResourceClimates de this
    * @param ProbaResourceClimateCollection $probaResourceClimates
    */
    public function setProbaResourceClimates(ProbaResourceClimateCollection $probaResourceClimates)
    {
        $this->cacheProbaResourceClimates = $probaResourceClimates;
    }

    /**
     * Renvoie les probaResourceClimates liés à ce TypeClimate
     * @return ProbaResourceClimateCollection|ProbaResourceClimate[]
     */
    public function getProbaResourceClimates() {
        if(is_null($this->cacheProbaResourceClimates)) {
            $this->cacheProbaResourceClimates = ProbaResourceClimateBusiness::getByTypeClimate($this);
            $this->cacheProbaResourceClimates->store();
        }
        return $this->cacheProbaResourceClimates;
    }

    /**
     * Crée un probaResourceClimate lié à ce TypeClimate
     * @return extended\ProbaResourceClimate
     */
    public function createProbaResourceClimate(){
        $probaResourceClimate = new extended\ProbaResourceClimate();
        $probaResourceClimate->setIdTypeClimateRef($this->idTypeClimate);
        return $probaResourceClimate;
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