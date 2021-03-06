<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\TypeResourceBonus;
use Fr\Nj2\Api\models\collection\TypeResourceBonusCollection;


class TypeResourceBonusBusiness extends BaseBusiness {

    protected static $fields = array(
        'idTypeResourceBonus'
        ,'idTypeResource'
        ,'idBonus'
        ,'era'
    );

    protected static $table = 'typeResourceBonus';

    /**
     * Renvoie le TypeResourceBonus demandé
     * @var int $id Id primaire du TypeResourceBonus
     * @return TypeResourceBonus
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeResourceBonusCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le TypeResourceBonus en DB
     * @param TypeResourceBonus $typeResourceBonus
     */
    public static function delete(TypeResourceBonus $typeResourceBonus) {
        $req = "DELETE FROM `typeResourceBonus` WHERE `idTypeResourceBonus` = '".$typeResourceBonus->getId()."';";
        DbHandler::delete($req);
    }
}
