<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TrajectoryCollection;
use Fr\Nj2\Api\models\Trajectory;


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