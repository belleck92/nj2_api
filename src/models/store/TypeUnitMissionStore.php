<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TypeUnitMissionCollection;
use Fr\Nj2\Api\models\TypeUnitMission;


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