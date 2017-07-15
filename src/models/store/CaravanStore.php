<?php
/**
* Created by Manu
* Date: 2017-07-15
* Time: 12:29:12
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\CaravanCollection;
use Fr\Nj2\Api\models\extended\Caravan;


class CaravanStore extends BaseStore {
    public static $table = 'caravan';

    /**
     * @param int $id
     * @return Caravan
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return CaravanCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}