<?php
/**
* Created by Manu
* Date: 2017-07-15
* Time: 12:29:12
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\BuildingCollection;
use Fr\Nj2\Api\models\extended\Building;


class BuildingStore extends BaseStore {
    public static $table = 'building';

    /**
     * @param int $id
     * @return Building
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return BuildingCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}