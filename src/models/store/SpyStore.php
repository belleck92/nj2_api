<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\SpyCollection;
use Fr\Nj2\Api\models\extended\Spy;


class SpyStore extends BaseStore {
    public static $table = 'spy';

    /**
     * @param int $id
     * @return Spy
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return SpyCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}