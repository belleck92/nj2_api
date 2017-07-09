<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 16:56:52
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\River;
use Fr\Nj2\Api\models\collection\RiverCollection;


class RiverBusiness extends BaseBusiness {

    protected static $fields = array(
        'idRiver'
        ,'idHexa'
        ,'side'
        ,'ford'
    );

    protected static $table = 'river';

    /**
     * Renvoie le River demandé
     * @var int $id Id primaire du River
     * @return River
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return RiverCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le River en DB
     * @param River $river
     */
    public static function delete(River $river) {
        $req = "DELETE FROM `river` WHERE `idRiver` = '".$river->getId()."';";
        DbHandler::delete($req);
    }
}
