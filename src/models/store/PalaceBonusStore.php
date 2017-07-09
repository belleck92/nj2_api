<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 15:09:50
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\PalaceBonusCollection;
use Fr\Nj2\Api\models\PalaceBonus;


class PalaceBonusStore extends BaseStore {
    public static $table = 'palaceBonus';

    /**
     * @param int $id
     * @return PalaceBonus
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return PalaceBonusCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}