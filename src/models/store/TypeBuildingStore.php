<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 17:30:19
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TypeBuildingCollection;
use Fr\Nj2\Api\models\extended\TypeBuilding;


class TypeBuildingStore extends BaseStore {
    public static $table = 'typeBuilding';

    /**
     * @param int $id
     * @return TypeBuilding
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeBuildingCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}