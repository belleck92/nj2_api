<?php
/**
* Created by Manu
* Date: 2017-06-16
* Time: 17:46:45
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