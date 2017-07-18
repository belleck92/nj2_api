<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\ExpertCollection;
use Fr\Nj2\Api\models\extended\Expert;


class ExpertStore extends BaseStore {
    public static $table = 'expert';

    /**
     * @param int $id
     * @return Expert
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return ExpertCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}