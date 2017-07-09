<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 18:24:10
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Hexa;
use Fr\Nj2\Api\models\collection\HexaCollection;
use Fr\Nj2\Api\models\collection\GameCollection;
use Fr\Nj2\Api\models\extended\Game;


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
     * Renvoie les Hexas liés aux Games de la collection fournie en paramètre
     * @param GameCollection $games
     * @return HexaCollection|Hexa[]
     */
    public static function getFromGames(GameCollection $games){
        $ids = $games->getIdsStr();
        if(!$ids) return new HexaCollection();
        $req = "SELECT * FROM hexa WHERE idGame IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'Hexa', 'HexaCollection');
    }

    /**
     * Renvoie les Hexas liés à un Game
     * @param Game $game
     * @return HexaCollection|Hexa[]
     */
    public static function getByGame(Game $game){
        $req = "SELECT * FROM hexa WHERE idGame = '".$game->getId()."';";
        return DbHandler::collFromQuery($req, 'Hexa', 'HexaCollection');
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
