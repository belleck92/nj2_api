<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\HexaCollection;
use Fr\Nj2\Api\models\Hexa;


class HexaStore extends BaseStore {
    public static $table = 'hexa';

    /**
     * @param int $id
     * @return Hexa
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return HexaCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}