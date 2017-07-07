<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\Hexa;
use Fr\Nj2\Api\models\collection\HexaCollection;


class HexaBusiness extends BaseBusiness {

    protected static $fields = array(
        'idHexa'
        ,'idGame'
        ,'idPlayer'
        ,'idTerritory'
        ,'idTypeClimate'
        ,'X'
        ,'Y'
        ,'name'
        ,'population'
        ,'malusConquest'
    );

    protected static $table = 'hexa';

    /**
     * Renvoie le Hexa demandé
     * @var int $id Id primaire du Hexa
     * @return Hexa
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return HexaCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le Hexa en DB
     * @param Hexa $hexa
     */
    public static function delete(Hexa $hexa) {
        $req = "DELETE FROM `hexa` WHERE `idHexa` = '".$hexa->getId()."';";
        DbHandler::delete($req);
    }
}
