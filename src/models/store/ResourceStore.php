<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\ResourceCollection;
use Fr\Nj2\Api\models\extended\Resource;


class ResourceStore extends BaseStore {
    public static $table = 'resource';

    /**
     * @param int $id
     * @return Resource
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return ResourceCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}