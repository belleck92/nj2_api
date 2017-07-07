<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\ResourceCollection;
use Fr\Nj2\Api\models\Resource;


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