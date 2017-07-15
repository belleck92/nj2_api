<?php
/**
* Created by Manu
* Date: 2017-07-15
* Time: 12:29:12
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Tech;
use Fr\Nj2\Api\models\collection\TechCollection;


class TechBusiness extends BaseBusiness {

    protected static $fields = array(
        'idTech'
        ,'idPlayer'
        ,'totalCost'
        ,'alreadyInvested'
    );

    protected static $table = 'tech';

    /**
     * Renvoie le Tech demandé
     * @var int $id Id primaire du Tech
     * @return Tech
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TechCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le Tech en DB
     * @param Tech $tech
     */
    public static function delete(Tech $tech) {
        $req = "DELETE FROM `tech` WHERE `idTech` = '".$tech->getId()."';";
        DbHandler::delete($req);
    }
}
