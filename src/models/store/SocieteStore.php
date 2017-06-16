<?php
/**
* Created by Manu
* Date: 2017-06-16
* Time: 17:46:45
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