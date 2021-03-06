<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TechCollection;
use Fr\Nj2\Api\models\extended\Tech;


class TechStore extends BaseStore {
    public static $table = 'tech';

    /**
     * @param int $id
     * @return Tech
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TechCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}