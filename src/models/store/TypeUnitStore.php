<?php
/**
* Created by Manu
* Date: 2017-07-12
* Time: 11:03:33
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TypeUnitCollection;
use Fr\Nj2\Api\models\extended\TypeUnit;


class TypeUnitStore extends BaseStore {
    public static $table = 'typeUnit';

    /**
     * @param int $id
     * @return TypeUnit
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeUnitCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}