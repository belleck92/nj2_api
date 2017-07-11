<?php
/**
* Created by Manu
* Date: 2017-07-11
* Time: 17:29:12
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Hq;
use Fr\Nj2\Api\models\collection\HqCollection;


class HqBusiness extends BaseBusiness {

    protected static $fields = array(
        'idHq'
        ,'idHexa'
        ,'idPlayer'
        ,'idTypeMission'
        ,'idTypeHq'
        ,'idTarget'
        ,'name'
        ,'level'
        ,'capop'
        ,'isPalaceBonus'
    );

    protected static $table = 'hq';

    /**
     * Renvoie le Hq demandé
     * @var int $id Id primaire du Hq
     * @return Hq
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return HqCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le Hq en DB
     * @param Hq $hq
     */
    public static function delete(Hq $hq) {
        $req = "DELETE FROM `hq` WHERE `idHq` = '".$hq->getId()."';";
        DbHandler::delete($req);
    }
}
