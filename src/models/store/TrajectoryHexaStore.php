<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TrajectoryHexaCollection;
use Fr\Nj2\Api\models\TrajectoryHexa;


class TrajectoryHexaStore extends BaseStore {
    public static $table = 'trajectoryHexa';

    /**
     * @param int $id
     * @return TrajectoryHexa
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TrajectoryHexaCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}