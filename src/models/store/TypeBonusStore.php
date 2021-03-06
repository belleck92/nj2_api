<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TypeBonusCollection;
use Fr\Nj2\Api\models\extended\TypeBonus;


class TypeBonusStore extends BaseStore {
    public static $table = 'typeBonus';

    /**
     * @param int $id
     * @return TypeBonus
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeBonusCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}