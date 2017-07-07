<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TypeClimateCollection;
use Fr\Nj2\Api\models\TypeClimate;


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