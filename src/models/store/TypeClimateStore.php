<?php
/**
* Created by Manu
* Date: 2017-07-12
* Time: 12:12:19
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