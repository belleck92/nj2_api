<?php
/**
* Created by Manu
* Date: 2017-06-27
* Time: 13:43:14
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\SocieteCollection;
use Fr\Nj2\Api\models\Societe;


class SocieteStore extends BaseStore {
    public static $table = 'societe';

    /**
     * @param int $id
     * @return Societe
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return SocieteCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}