<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\BonusCollection;
use Fr\Nj2\Api\models\extended\Bonus;


class BonusStore extends BaseStore {
    public static $table = 'bonus';

    /**
     * @param int $id
     * @return Bonus
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return BonusCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}