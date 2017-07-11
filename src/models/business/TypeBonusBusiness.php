<?php
/**
* Created by Manu
* Date: 2017-07-11
* Time: 17:29:12
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\TypeBonus;
use Fr\Nj2\Api\models\collection\TypeBonusCollection;


class TypeBonusBusiness extends BaseBusiness {

    protected static $fields = array(
        'idTypeBonus'
        ,'name'
        ,'description'
        ,'fctId'
    );

    protected static $table = 'typeBonus';

    /**
     * Renvoie le TypeBonus demandé
     * @var int $id Id primaire du TypeBonus
     * @return TypeBonus
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeBonusCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le TypeBonus en DB
     * @param TypeBonus $typeBonus
     */
    public static function delete(TypeBonus $typeBonus) {
        $req = "DELETE FROM `typeBonus` WHERE `idTypeBonus` = '".$typeBonus->getId()."';";
        DbHandler::delete($req);
    }
}
