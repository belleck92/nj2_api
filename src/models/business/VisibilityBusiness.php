<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Visibility;
use Fr\Nj2\Api\models\collection\VisibilityCollection;
use Fr\Nj2\Api\models\collection\HexaCollection;
use Fr\Nj2\Api\models\extended\Hexa;
use Fr\Nj2\Api\models\collection\PlayerCollection;
use Fr\Nj2\Api\models\extended\Player;


class VisibilityBusiness extends BaseBusiness {

    protected static $fields = array(
        'idVisibility'
        ,'idPlayer'
        ,'idHexa'
        ,'level'
    );

    protected static $table = 'visibility';

    /**
     * Renvoie le Visibility demandé
     * @var int $id Id primaire du Visibility
     * @return Visibility
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return VisibilityCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
    /**
     * Renvoie les Visibilitys liés aux Hexas de la collection fournie en paramètre
     * @param HexaCollection $hexas
     * @return VisibilityCollection|Visibility[]
     */
    public static function getFromHexas(HexaCollection $hexas){
        $ids = $hexas->getIdsStr();
        if(!$ids) return new VisibilityCollection();
        $req = "SELECT * FROM visibility WHERE idHexa IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'Visibility', 'VisibilityCollection');
    }

    /**
     * Renvoie les Visibilitys liés à un Hexa
     * @param Hexa $hexa
     * @return VisibilityCollection|Visibility[]
     */
    public static function getByHexa(Hexa $hexa){
        $req = "SELECT * FROM visibility WHERE idHexa = '".$hexa->getId()."';";
        return DbHandler::collFromQuery($req, 'Visibility', 'VisibilityCollection');
    }
    
    /**
     * Renvoie les Visibilitys liés aux Players de la collection fournie en paramètre
     * @param PlayerCollection $players
     * @return VisibilityCollection|Visibility[]
     */
    public static function getFromPlayers(PlayerCollection $players){
        $ids = $players->getIdsStr();
        if(!$ids) return new VisibilityCollection();
        $req = "SELECT * FROM visibility WHERE idPlayer IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'Visibility', 'VisibilityCollection');
    }

    /**
     * Renvoie les Visibilitys liés à un Player
     * @param Player $player
     * @return VisibilityCollection|Visibility[]
     */
    public static function getByPlayer(Player $player){
        $req = "SELECT * FROM visibility WHERE idPlayer = '".$player->getId()."';";
        return DbHandler::collFromQuery($req, 'Visibility', 'VisibilityCollection');
    }
    
     /**
     * Supprime le Visibility en DB
     * @param Visibility $visibility
     */
    public static function delete(Visibility $visibility) {
        $req = "DELETE FROM `visibility` WHERE `idVisibility` = '".$visibility->getId()."';";
        DbHandler::delete($req);
    }
}
