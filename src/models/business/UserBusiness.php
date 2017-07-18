<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\User;
use Fr\Nj2\Api\models\collection\UserCollection;
use Fr\Nj2\Api\models\collection\PlayerCollection;


class UserBusiness extends BaseBusiness {

    protected static $fields = array(
        'idUser'
        ,'email'
        ,'password'
        ,'role'
    );

    protected static $table = 'user';

    /**
     * Renvoie le User demandé
     * @var int $id Id primaire du User
     * @return User
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return UserCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
    
    /**
     * Renvoie les Users liés à une collection de Players
     * @param PlayerCollection $players
     * @return UserCollection|User[]
     */
    public static function getFromPlayers(PlayerCollection $players){
        $ids = $players->getIdUserStr();
        if(!$ids) return new UserCollection();
        $req = "SELECT * FROM user WHERE idUser IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'User', 'UserCollection');
    }
 /**
     * Supprime le User en DB
     * @param User $user
     */
    public static function delete(User $user) {
        $req = "DELETE FROM `user` WHERE `idUser` = '".$user->getId()."';";
        DbHandler::delete($req);
    }
}
