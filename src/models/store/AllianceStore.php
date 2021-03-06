<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\AllianceCollection;
use Fr\Nj2\Api\models\extended\Alliance;


class AllianceStore extends BaseStore {
    public static $table = 'alliance';

    /**
     * @param int $id
     * @return Alliance
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return AllianceCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}