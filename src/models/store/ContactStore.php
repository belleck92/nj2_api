<?php
/**
* Created by Manu
* Date: 2017-06-19
* Time: 18:26:05
*/
namespace Fr\Nj2\Api\models\store;


use Fr\Nj2\Api\models\Contact;


class ContactStore extends BaseStore {
    public static $table = 'contact';

    /**
     * @param int $id
     * @return Contact
     */
    public static function getById($id)
    {
        return parent::getById($id);
    }
}