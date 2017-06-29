<?php
/**
* Created by Manu
* Date: 2017-06-27
* Time: 13:43:14
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\collection\ContactCollection;
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

    /**
     * @param string $ids
     * @return ContactCollection
     * @throws \Exception
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }
}