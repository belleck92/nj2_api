<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 18:24:11
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\PlayerCollection;
use Fr\Nj2\Api\models\extended\Player;


class PlayerStore extends BaseStore {
    public static $table = 'player';

    /**
     * @param int $id
     * @return Player
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return PlayerCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}