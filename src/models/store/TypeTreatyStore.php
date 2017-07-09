<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 17:30:19
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TypeTreatyCollection;
use Fr\Nj2\Api\models\extended\TypeTreaty;


class TypeTreatyStore extends BaseStore {
    public static $table = 'typeTreaty';

    /**
     * @param int $id
     * @return TypeTreaty
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeTreatyCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}