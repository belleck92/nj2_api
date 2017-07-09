<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 15:09:50
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\Alliance;
use Fr\Nj2\Api\models\collection\AllianceCollection;


class AllianceBusiness extends BaseBusiness {

    protected static $fields = array(
        'idAlliance'
        ,'name'
        ,'idLeader'
    );

    protected static $table = 'alliance';

    /**
     * Renvoie le Alliance demandé
     * @var int $id Id primaire du Alliance
     * @return Alliance
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return AllianceCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le Alliance en DB
     * @param Alliance $alliance
     */
    public static function delete(Alliance $alliance) {
        $req = "DELETE FROM `alliance` WHERE `idAlliance` = '".$alliance->getId()."';";
        DbHandler::delete($req);
    }
}
