<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Unit;
use Fr\Nj2\Api\models\collection\UnitCollection;


class UnitBusiness extends BaseBusiness {

    protected static $fields = array(
        'idUnit'
        ,'idTypeUnit'
        ,'idHq'
        ,'idHexa'
        ,'buildingTurnsLeft'
        ,'name'
        ,'morale'
        ,'xp'
    );

    protected static $table = 'unit';

    /**
     * Renvoie le Unit demandé
     * @var int $id Id primaire du Unit
     * @return Unit
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return UnitCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le Unit en DB
     * @param Unit $unit
     */
    public static function delete(Unit $unit) {
        $req = "DELETE FROM `unit` WHERE `idUnit` = '".$unit->getId()."';";
        DbHandler::delete($req);
    }
}
