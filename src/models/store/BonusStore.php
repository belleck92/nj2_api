<?php
/**
* Created by Manu
* Date: 2017-07-14
* Time: 11:44:36
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