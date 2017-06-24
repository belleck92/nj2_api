<?php
/**
* Created by Manu
* Date: 2017-06-24
* Time: 14:27:39
*/
namespace Fr\Nj2\Api\models\store;


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
}