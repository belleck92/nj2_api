<?php
/**
* Created by Manu
* Date: 2017-07-15
* Time: 12:29:12
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