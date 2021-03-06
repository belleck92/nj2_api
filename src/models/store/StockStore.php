<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\StockCollection;
use Fr\Nj2\Api\models\extended\Stock;


class StockStore extends BaseStore {
    public static $table = 'stock';

    /**
     * @param int $id
     * @return Stock
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return StockCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}