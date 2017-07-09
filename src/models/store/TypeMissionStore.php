<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 16:56:53
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TypeMissionCollection;
use Fr\Nj2\Api\models\extended\TypeMission;


class TypeMissionStore extends BaseStore {
    public static $table = 'typeMission';

    /**
     * @param int $id
     * @return TypeMission
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeMissionCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}