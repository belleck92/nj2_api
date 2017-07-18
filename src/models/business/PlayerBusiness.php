<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Player;
use Fr\Nj2\Api\models\collection\PlayerCollection;
use Fr\Nj2\Api\models\collection\GameCollection;
use Fr\Nj2\Api\models\extended\Game;
use Fr\Nj2\Api\models\collection\UserCollection;
use Fr\Nj2\Api\models\extended\User;
use Fr\Nj2\Api\models\collection\HexaCollection;


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
     * Renvoie les Players liés aux Games de la collection fournie en paramètre
     * @param GameCollection $games
     * @return PlayerCollection|Player[]
     */
    public static function getFromGames(GameCollection $games){
        $ids = $games->getIdsStr();
        if(!$ids) return new PlayerCollection();
        $req = "SELECT * FROM player WHERE idGame IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'Player', 'PlayerCollection');
    }

    /**
     * Renvoie les Players liés à un Game
     * @param Game $game
     * @return PlayerCollection|Player[]
     */
    public static function getByGame(Game $game){
        $req = "SELECT * FROM player WHERE idGame = '".$game->getId()."';";
        return DbHandler::collFromQuery($req, 'Player', 'PlayerCollection');
    }
    
    /**
     * Renvoie les Players liés aux Users de la collection fournie en paramètre
     * @param UserCollection $users
     * @return PlayerCollection|Player[]
     */
    public static function getFromUsers(UserCollection $users){
        $ids = $users->getIdsStr();
        if(!$ids) return new PlayerCollection();
        $req = "SELECT * FROM player WHERE idUser IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'Player', 'PlayerCollection');
    }

    /**
     * Renvoie les Players liés à un User
     * @param User $user
     * @return PlayerCollection|Player[]
     */
    public static function getByUser(User $user){
        $req = "SELECT * FROM player WHERE idUser = '".$user->getId()."';";
        return DbHandler::collFromQuery($req, 'Player', 'PlayerCollection');
    }
    
    
    /**
     * Renvoie les Players liés à une collection de Hexas
     * @param HexaCollection $hexas
     * @return PlayerCollection|Player[]
     */
    public static function getFromHexas(HexaCollection $hexas){
        $ids = $hexas->getIdTerritoryStr();
        if(!$ids) return new PlayerCollection();
        $req = "SELECT * FROM player WHERE idPlayer IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'Player', 'PlayerCollection');
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
