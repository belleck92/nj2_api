<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 17:30:19
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Spy;
use Fr\Nj2\Api\models\collection\SpyCollection;


class SpyBusiness extends BaseBusiness {

    protected static $fields = array(
        'idSpy'
        ,'idPlayer'
        ,'idHexa'
        ,'idTypeMission'
        ,'idTarget'
        ,'infiltrated'
        ,'turnsLeft'
    );

    protected static $table = 'spy';

    /**
     * Renvoie le Spy demandé
     * @var int $id Id primaire du Spy
     * @return Spy
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return SpyCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le Spy en DB
     * @param Spy $spy
     */
    public static function delete(Spy $spy) {
        $req = "DELETE FROM `spy` WHERE `idSpy` = '".$spy->getId()."';";
        DbHandler::delete($req);
    }
}
