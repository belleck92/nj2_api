<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TypeHqCollection;
use Fr\Nj2\Api\models\extended\TypeHq;


class TypeHqStore extends BaseStore {
    public static $table = 'typeHq';

    /**
     * @param int $id
     * @return TypeHq
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeHqCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}