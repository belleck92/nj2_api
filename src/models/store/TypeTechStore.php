<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\TypeTechCollection;
use Fr\Nj2\Api\models\TypeTech;


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