<?php
/**
* Created by Manu
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