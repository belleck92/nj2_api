<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\HqCollection;
use Fr\Nj2\Api\models\extended\Hq;


class HqStore extends BaseStore {
    public static $table = 'hq';

    /**
     * @param int $id
     * @return Hq
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return HqCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}