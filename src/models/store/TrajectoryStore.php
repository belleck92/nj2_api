<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TrajectoryCollection;
use Fr\Nj2\Api\models\extended\Trajectory;


class TrajectoryStore extends BaseStore {
    public static $table = 'trajectory';

    /**
     * @param int $id
     * @return Trajectory
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TrajectoryCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}