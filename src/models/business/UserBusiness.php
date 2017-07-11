<?php
/**
* Created by Manu
* Date: 2017-07-10
* Time: 17:24:40
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\User;
use Fr\Nj2\Api\models\collection\UserCollection;


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
     * Supprime le User en DB
     * @param User $user
     */
    public static function delete(User $user) {
        $req = "DELETE FROM `user` WHERE `idUser` = '".$user->getId()."';";
        DbHandler::delete($req);
    }
}
