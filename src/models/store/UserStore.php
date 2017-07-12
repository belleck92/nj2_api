<?php
/**
* Created by Manu
* Date: 2017-07-12
* Time: 11:03:33
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\UserCollection;
use Fr\Nj2\Api\models\extended\User;


class UserStore extends BaseStore {
    public static $table = 'user';

    /**
     * @param int $id
     * @return User
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return UserCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}