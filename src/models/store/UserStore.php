<?php
/**
* Created by Manu
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