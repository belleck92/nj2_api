<?php
/**
* Created by Manu
* Date: 2017-07-11
* Time: 17:29:13
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\RiverCollection;
use Fr\Nj2\Api\models\extended\River;


class RiverStore extends BaseStore {
    public static $table = 'river';

    /**
     * @param int $id
     * @return River
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return RiverCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}