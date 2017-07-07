<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\AllianceCollection;
use Fr\Nj2\Api\models\Alliance;


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