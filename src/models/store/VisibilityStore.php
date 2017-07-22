<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\VisibilityCollection;
use Fr\Nj2\Api\models\extended\Visibility;


class VisibilityStore extends BaseStore {
    public static $table = 'visibility';

    /**
     * @param int $id
     * @return Visibility
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return VisibilityCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}