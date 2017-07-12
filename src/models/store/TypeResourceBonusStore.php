<?php
/**
* Created by Manu
* Date: 2017-07-12
* Time: 12:12:19
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TypeResourceBonusCollection;
use Fr\Nj2\Api\models\extended\TypeResourceBonus;


class TypeResourceBonusStore extends BaseStore {
    public static $table = 'typeResourceBonus';

    /**
     * @param int $id
     * @return TypeResourceBonus
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeResourceBonusCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}