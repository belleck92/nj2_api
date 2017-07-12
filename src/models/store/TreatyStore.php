<?php
/**
* Created by Manu
* Date: 2017-07-12
* Time: 11:03:33
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TreatyCollection;
use Fr\Nj2\Api\models\extended\Treaty;


class TreatyStore extends BaseStore {
    public static $table = 'treaty';

    /**
     * @param int $id
     * @return Treaty
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TreatyCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}