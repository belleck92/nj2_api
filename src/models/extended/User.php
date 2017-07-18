<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-09
 * Time: 16:40:03
 */

namespace Fr\Nj2\Api\models\extended;

use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\DbHandler;

class User extends \Fr\Nj2\Api\models\User
{
    /**
     * @param $user
     * @param $password
     * @return User
     * @throws \Exception
     */
    public static function getByUserPassword($user, $password)
    {
        $req = "SELECT * FROM `user` WHERE email = '".DbHandler::getConn()->escape_string($user)."' AND password = PASSWORD('".DbHandler::getConn()->escape_string($password)."');";
        return DbHandler::objFromQuery($req,BaseBusiness::underscoreToCamelCase('user'));
    }
}