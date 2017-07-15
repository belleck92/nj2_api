<?php
/**
* Created by Manu
* Date: 2017-07-15
* Time: 12:29:12
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\TypeClimate;
use Fr\Nj2\Api\models\collection\TypeClimateCollection;
use Fr\Nj2\Api\models\collection\HexaCollection;
use Fr\Nj2\Api\models\collection\ProbaResourceClimateCollection;


class TypeClimateBusiness extends BaseBusiness {

    protected static $fields = array(
        'idTypeClimate'
        ,'name'
        ,'description'
        ,'fctId'
        ,'food'
        ,'defenseBonus'
    );

    protected static $table = 'typeClimate';

    /**
     * Renvoie le TypeClimate demandé
     * @var int $id Id primaire du TypeClimate
     * @return TypeClimate
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeClimateCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
    
    /**
     * Renvoie les TypeClimates liés à une collection de Hexas
     * @param HexaCollection $hexas
     * @return TypeClimateCollection|TypeClimate[]
     */
    public static function getFromHexas(HexaCollection $hexas){
        $ids = $hexas->getIdTypeClimateStr();
        if(!$ids) return new TypeClimateCollection();
        $req = "SELECT * FROM typeClimate WHERE idTypeClimate IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'TypeClimate', 'TypeClimateCollection');
    }

    /**
     * Renvoie les TypeClimates liés à une collection de ProbaResourceClimates
     * @param ProbaResourceClimateCollection $probaResourceClimates
     * @return TypeClimateCollection|TypeClimate[]
     */
    public static function getFromProbaResourceClimates(ProbaResourceClimateCollection $probaResourceClimates){
        $ids = $probaResourceClimates->getIdTypeClimateStr();
        if(!$ids) return new TypeClimateCollection();
        $req = "SELECT * FROM typeClimate WHERE idTypeClimate IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'TypeClimate', 'TypeClimateCollection');
    }
 /**
     * Supprime le TypeClimate en DB
     * @param TypeClimate $typeClimate
     */
    public static function delete(TypeClimate $typeClimate) {
        $req = "DELETE FROM `typeClimate` WHERE `idTypeClimate` = '".$typeClimate->getId()."';";
        DbHandler::delete($req);
    }
}
