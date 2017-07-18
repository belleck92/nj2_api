<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TypeTechCollection;
use Fr\Nj2\Api\models\extended\TypeTech;


class TypeTechStore extends BaseStore {
    public static $table = 'typeTech';

    /**
     * @param int $id
     * @return TypeTech
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeTechCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}