<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 16/06/17
 * Time: 13:29
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\ContactBusiness;
use Fr\Nj2\Api\v1\LogicalUnit;

class Contacts extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'contact';

    public function getByIds($ids)
    {echo __LINE__;
        return ContactBusiness::getByIds($ids);
    }
}