<?php
/**
* Created by Manu
* Date: 2017-07-10
* Time: 17:24:40
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TypeTechBonusCollection;
use Fr\Nj2\Api\models\extended\TypeTechBonus;


class TypeTechBonusStore extends BaseStore {
    public static $table = 'typeTechBonus';

    /**
     * @param int $id
     * @return TypeTechBonus
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeTechBonusCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}