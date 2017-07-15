<?php
/**
* Created by Manu
* Date: 2017-07-15
* Time: 12:29:12
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\ParameterCollection;
use Fr\Nj2\Api\models\extended\Parameter;


class ParameterStore extends BaseStore {
    public static $table = 'parameter';

    /**
     * @param int $id
     * @return Parameter
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return ParameterCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}