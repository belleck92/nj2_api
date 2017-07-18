<?php
/**
* Created by Manu
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