<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Game;
use Fr\Nj2\Api\models\collection\GameCollection;
use Fr\Nj2\Api\models\collection\HexaCollection;
use Fr\Nj2\Api\models\collection\PlayerCollection;


class GameBusiness extends BaseBusiness {

    protected static $fields = array(
        'idGame'
        ,'currentTurn'
        ,'maxTurns'
        ,'name'
        ,'started'
        ,'width'
        ,'height'
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
     * Renvoie les Games liés à une collection de Hexas
     * @param HexaCollection $hexas
     * @return GameCollection|Game[]
     */
    public static function getFromHexas(HexaCollection $hexas){
        $ids = $hexas->getIdGameStr();
        if(!$ids) return new GameCollection();
        $req = "SELECT * FROM game WHERE idGame IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'Game', 'GameCollection');
    }

    /**
     * Renvoie les Games liés à une collection de Players
     * @param PlayerCollection $players
     * @return GameCollection|Game[]
     */
    public static function getFromPlayers(PlayerCollection $players){
        $ids = $players->getIdGameStr();
        if(!$ids) return new GameCollection();
        $req = "SELECT * FROM game WHERE idGame IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'Game', 'GameCollection');
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
