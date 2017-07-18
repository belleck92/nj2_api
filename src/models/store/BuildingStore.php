<?php
/**
* Created by Manu
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