<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TypeClimateCollection;
use Fr\Nj2\Api\models\extended\TypeClimate;


class TypeClimateStore extends BaseStore {
    public static $table = 'typeClimate';

    /**
     * @param int $id
     * @return TypeClimate
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeClimateCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}