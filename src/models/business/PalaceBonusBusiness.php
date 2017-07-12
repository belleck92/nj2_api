<?php
/**
* Created by Manu
* Date: 2017-07-12
* Time: 11:03:33
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\PalaceBonus;
use Fr\Nj2\Api\models\collection\PalaceBonusCollection;


class PalaceBonusBusiness extends BaseBusiness {

    protected static $fields = array(
        'idPalaceBonus'
        ,'idPlayer'
        ,'idTypeBonus'
    );

    protected static $table = 'palaceBonus';

    /**
     * Renvoie le PalaceBonus demandé
     * @var int $id Id primaire du PalaceBonus
     * @return PalaceBonus
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return PalaceBonusCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le PalaceBonus en DB
     * @param PalaceBonus $palaceBonus
     */
    public static function delete(PalaceBonus $palaceBonus) {
        $req = "DELETE FROM `palaceBonus` WHERE `idPalaceBonus` = '".$palaceBonus->getId()."';";
        DbHandler::delete($req);
    }
}
