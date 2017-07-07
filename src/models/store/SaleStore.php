<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\SaleCollection;
use Fr\Nj2\Api\models\Sale;


class SaleStore extends BaseStore {
    public static $table = 'sale';

    /**
     * @param int $id
     * @return Sale
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return SaleCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}