<?php
/**
* Created by Manu
* Date: 2017-07-12
* Time: 11:03:33
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\GameCollection;
use Fr\Nj2\Api\models\extended\Game;


class GameStore extends BaseStore {
    public static $table = 'game';

    /**
     * @param int $id
     * @return Game
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return GameCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}