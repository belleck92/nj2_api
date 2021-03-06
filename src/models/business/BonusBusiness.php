<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Bonus;
use Fr\Nj2\Api\models\collection\BonusCollection;


class BonusBusiness extends BaseBusiness {

    protected static $fields = array(
        'idBonus'
        ,'idTypeBonus'
        ,'idTypeBuilding'
        ,'era'
        ,'idTypeResource'
        ,'idTypeUnit'
        ,'value'
    );

    protected static $table = 'bonus';

    /**
     * Renvoie le Bonus demandé
     * @var int $id Id primaire du Bonus
     * @return Bonus
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return BonusCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le Bonus en DB
     * @param Bonus $bonus
     */
    public static function delete(Bonus $bonus) {
        $req = "DELETE FROM `bonus` WHERE `idBonus` = '".$bonus->getId()."';";
        DbHandler::delete($req);
    }
}
