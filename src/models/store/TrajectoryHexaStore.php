<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TrajectoryHexaCollection;
use Fr\Nj2\Api\models\extended\TrajectoryHexa;


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