<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Hexa;
use Fr\Nj2\Api\models\collection\HexaCollection;
use Fr\Nj2\Api\models\collection\GameCollection;
use Fr\Nj2\Api\models\extended\Game;
use Fr\Nj2\Api\models\collection\TypeClimateCollection;
use Fr\Nj2\Api\models\extended\TypeClimate;
use Fr\Nj2\Api\models\collection\PlayerCollection;
use Fr\Nj2\Api\models\extended\Player;
use Fr\Nj2\Api\models\collection\ResourceCollection;
use Fr\Nj2\Api\models\collection\VisibilityCollection;
use Fr\Nj2\Api\models\collection\RiverCollection;


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
     * Renvoie les Hexas liés aux TypeClimates de la collection fournie en paramètre
     * @param TypeClimateCollection $typeClimates
     * @return HexaCollection|Hexa[]
     */
    public static function getFromTypeClimates(TypeClimateCollection $typeClimates){
        $ids = $typeClimates->getIdsStr();
        if(!$ids) return new HexaCollection();
        $req = "SELECT * FROM hexa WHERE idTypeClimate IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'Hexa', 'HexaCollection');
    }

    /**
     * Renvoie les Hexas liés à un TypeClimate
     * @param TypeClimate $typeClimate
     * @return HexaCollection|Hexa[]
     */
    public static function getByTypeClimate(TypeClimate $typeClimate){
        $req = "SELECT * FROM hexa WHERE idTypeClimate = '".$typeClimate->getId()."';";
        return DbHandler::collFromQuery($req, 'Hexa', 'HexaCollection');
    }
    
    /**
     * Renvoie les Hexas liés aux Players de la collection fournie en paramètre
     * @param PlayerCollection $players
     * @return HexaCollection|Hexa[]
     */
    public static function getFromPlayers(PlayerCollection $players){
        $ids = $players->getIdsStr();
        if(!$ids) return new HexaCollection();
        $req = "SELECT * FROM hexa WHERE idTerritory IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'Hexa', 'HexaCollection');
    }

    /**
     * Renvoie les Hexas liés à un Player
     * @param Player $player
     * @return HexaCollection|Hexa[]
     */
    public static function getByPlayer(Player $player){
        $req = "SELECT * FROM hexa WHERE idTerritory = '".$player->getId()."';";
        return DbHandler::collFromQuery($req, 'Hexa', 'HexaCollection');
    }
    
    
    /**
     * Renvoie les Hexas liés à une collection de Resources
     * @param ResourceCollection $resources
     * @return HexaCollection|Hexa[]
     */
    public static function getFromResources(ResourceCollection $resources){
        $ids = $resources->getIdHexaStr();
        if(!$ids) return new HexaCollection();
        $req = "SELECT * FROM hexa WHERE idHexa IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'Hexa', 'HexaCollection');
    }

    /**
     * Renvoie les Hexas liés à une collection de Visibilitys
     * @param VisibilityCollection $visibilitys
     * @return HexaCollection|Hexa[]
     */
    public static function getFromVisibilitys(VisibilityCollection $visibilitys){
        $ids = $visibilitys->getIdHexaStr();
        if(!$ids) return new HexaCollection();
        $req = "SELECT * FROM hexa WHERE idHexa IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'Hexa', 'HexaCollection');
    }

    /**
     * Renvoie les Hexas liés à une collection de Rivers
     * @param RiverCollection $rivers
     * @return HexaCollection|Hexa[]
     */
    public static function getFromRivers(RiverCollection $rivers){
        $ids = $rivers->getIdHexaStr();
        if(!$ids) return new HexaCollection();
        $req = "SELECT * FROM hexa WHERE idHexa IN (".$ids.");";
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
