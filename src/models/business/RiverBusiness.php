<?php
/**
* Created by Manu
* Date: 2017-07-14
* Time: 11:44:36
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\River;
use Fr\Nj2\Api\models\collection\RiverCollection;
use Fr\Nj2\Api\models\collection\HexaCollection;
use Fr\Nj2\Api\models\extended\Hexa;


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
     * Renvoie les Rivers liés aux Hexas de la collection fournie en paramètre
     * @param HexaCollection $hexas
     * @return RiverCollection|River[]
     */
    public static function getFromHexas(HexaCollection $hexas){
        $ids = $hexas->getIdsStr();
        if(!$ids) return new RiverCollection();
        $req = "SELECT * FROM river WHERE idHexa IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'River', 'RiverCollection');
    }

    /**
     * Renvoie les Rivers liés à un Hexa
     * @param Hexa $hexa
     * @return RiverCollection|River[]
     */
    public static function getByHexa(Hexa $hexa){
        $req = "SELECT * FROM river WHERE idHexa = '".$hexa->getId()."';";
        return DbHandler::collFromQuery($req, 'River', 'RiverCollection');
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
