<?php
/**
* Created by Manu
* Date: 2017-07-10
* Time: 17:24:40
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TypeResourceCollection;
use Fr\Nj2\Api\models\extended\TypeResource;


class TypeResourceStore extends BaseStore {
    public static $table = 'typeResource';

    /**
     * @param int $id
     * @return TypeResource
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeResourceCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}