<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\Player;
use Fr\Nj2\Api\models\collection\PlayerCollection;


class PlayerBusiness extends BaseBusiness {

    protected static $fields = array(
        'idPlayer'
        ,'idUser'
        ,'idGame'
        ,'idAlliance'
        ,'name'
        ,'treasure'
        ,'color'
        ,'capitalCity'
        ,'lastResolutionEvents'
        ,'taxRate'
    );

    protected static $table = 'player';

    /**
     * Renvoie le Player demandé
     * @var int $id Id primaire du Player
     * @return Player
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return PlayerCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le Player en DB
     * @param Player $player
     */
    public static function delete(Player $player) {
        $req = "DELETE FROM `player` WHERE `idPlayer` = '".$player->getId()."';";
        DbHandler::delete($req);
    }
}
