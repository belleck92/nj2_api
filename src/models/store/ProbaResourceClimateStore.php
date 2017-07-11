<?php
/**
* Created by Manu
* Date: 2017-07-11
* Time: 17:29:13
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\ProbaResourceClimateCollection;
use Fr\Nj2\Api\models\extended\ProbaResourceClimate;


class ProbaResourceClimateStore extends BaseStore {
    public static $table = 'probaResourceClimate';

    /**
     * @param int $id
     * @return ProbaResourceClimate
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return ProbaResourceClimateCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}