<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 16:56:53
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\UnitCollection;
use Fr\Nj2\Api\models\extended\Unit;


class UnitStore extends BaseStore {
    public static $table = 'unit';

    /**
     * @param int $id
     * @return Unit
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return UnitCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}