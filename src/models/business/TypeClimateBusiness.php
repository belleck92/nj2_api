<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 15:09:50
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\TypeClimate;
use Fr\Nj2\Api\models\collection\TypeClimateCollection;


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
     * Supprime le TypeClimate en DB
     * @param TypeClimate $typeClimate
     */
    public static function delete(TypeClimate $typeClimate) {
        $req = "DELETE FROM `typeClimate` WHERE `idTypeClimate` = '".$typeClimate->getId()."';";
        DbHandler::delete($req);
    }
}
