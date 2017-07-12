<?php
/**
* Created by Manu
* Date: 2017-07-12
* Time: 11:03:33
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Caravan;
use Fr\Nj2\Api\models\collection\CaravanCollection;


class CaravanBusiness extends BaseBusiness {

    protected static $fields = array(
        'idCaravan'
        ,'idPlayer'
        ,'idTypeRessource'
        ,'qty'
        ,'turnsLeft'
    );

    protected static $table = 'caravan';

    /**
     * Renvoie le Caravan demandé
     * @var int $id Id primaire du Caravan
     * @return Caravan
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return CaravanCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le Caravan en DB
     * @param Caravan $caravan
     */
    public static function delete(Caravan $caravan) {
        $req = "DELETE FROM `caravan` WHERE `idCaravan` = '".$caravan->getId()."';";
        DbHandler::delete($req);
    }
}
