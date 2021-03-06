<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TypeUnitMissionCollection;
use Fr\Nj2\Api\models\extended\TypeUnitMission;


class TypeUnitMissionStore extends BaseStore {
    public static $table = 'typeUnitMission';

    /**
     * @param int $id
     * @return TypeUnitMission
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeUnitMissionCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}