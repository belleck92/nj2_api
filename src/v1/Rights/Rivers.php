<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
* Date: 2017-07-09
* Time: 16:55:27
*/

namespace Fr\Nj2\Api\v1\Rights;

use Fr\Nj2\Api\models\Bean;
use Fr\Nj2\Api\v1\Right;

class Rivers extends Right
{
    public static function canSee(Bean $bean)
    {
        return true;
    }

    public static function readableFields(Bean $bean)
    {
        return array_intersect_key($bean->getAsArray(),array_flip([
            'idRiver'
            ,'idHexa'
            ,'side'
            ,'ford'
        ]));
    }

}