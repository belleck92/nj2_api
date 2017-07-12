<?php
/**
* Created by Manu
* Date: 2017-07-12
* Time: 11:03:33
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Treaty;
use Fr\Nj2\Api\models\collection\TreatyCollection;


class TreatyBusiness extends BaseBusiness {

    protected static $fields = array(
        'idTreaty'
        ,'idTypeTreaty'
        ,'idPlayer1'
        ,'idPlayer2'
        ,'idAlliance1'
        ,'idAlliance2'
        ,'state'
        ,'startingTurn'
        ,'amount'
        ,'turnsLeft'
    );

    protected static $table = 'treaty';

    /**
     * Renvoie le Treaty demandé
     * @var int $id Id primaire du Treaty
     * @return Treaty
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TreatyCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le Treaty en DB
     * @param Treaty $treaty
     */
    public static function delete(Treaty $treaty) {
        $req = "DELETE FROM `treaty` WHERE `idTreaty` = '".$treaty->getId()."';";
        DbHandler::delete($req);
    }
}
