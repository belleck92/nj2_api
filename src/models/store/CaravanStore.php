<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\CaravanCollection;
use Fr\Nj2\Api\models\Caravan;


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