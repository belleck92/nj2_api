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

class Games extends Right
{
    public static function canSee(Bean $bean)
    {
        return true;
    }

    public static function readableFields(Bean $bean)
    {
        return array_intersect_key($bean->getAsArray(),array_flip([
            'idGame'
            ,'currentTurn'
            ,'maxTurns'
            ,'name'
            ,'started'
            ,'width'
            ,'height'
        ]));
    }

    public static function canWrite($data)
    {
        return true;
    }

    public static function writeableFields($data)
    {
        return array_intersect_key($data,array_flip([
            'idGame'
            ,'currentTurn'
            ,'maxTurns'
            ,'name'
            ,'started'
            ,'width'
            ,'height'
        ]));
    }

    public static function canDelete($bean)
    {
        return true;
    }

}