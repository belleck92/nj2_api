<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\Game;
use Fr\Nj2\Api\models\collection\GameCollection;


class GameBusiness extends BaseBusiness {

    protected static $fields = array(
        'idGame'
        ,'currentTurn'
        ,'maxTurns'
        ,'name'
        ,'started'
    );

    protected static $table = 'game';

    /**
     * Renvoie le Game demandé
     * @var int $id Id primaire du Game
     * @return Game
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return GameCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le Game en DB
     * @param Game $game
     */
    public static function delete(Game $game) {
        $req = "DELETE FROM `game` WHERE `idGame` = '".$game->getId()."';";
        DbHandler::delete($req);
    }
}
