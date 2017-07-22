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

class Hexas extends Right
{
    public static function canSee(Bean $bean)
    {
        return true;
    }

    public static function readableFields(Bean $bean)
    {
        return array_intersect_key($bean->getAsArray(),array_flip([
            'idHexa'
            ,'idGame'
            ,'idPlayer'
            ,'idTerritory'
            ,'idTypeClimate'
            ,'X'
            ,'Y'
            ,'name'
            ,'population'
            ,'malusConquest'
            ,'typeClimate'
            ,'idNeighbor0'
            ,'idNeighbor1'
            ,'idNeighbor2'
            ,'idNeighbor3' 
            ,'idNeighbor4'
            ,'idNeighbor5'
            ,'fronteer0'
            ,'fronteer1'
            ,'fronteer2'
            ,'fronteer3'
            ,'fronteer4'
            ,'fronteer5'
            ,'resources'
            ,'rivers'
            ,'foodProduction'
            ,'defenseBonus'
        ]));
    }

    public static function canWrite($data)
    {
        return parent::canWrite($data); // TODO: Change the autogenerated stub
    }

    public static function writeableFields($data)
    {
        return array_intersect_key($data,array_flip([
            'idHexa'
            ,'idGame'
            ,'idPlayer'
            ,'idTerritory'
            ,'idTypeClimate'
            ,'X'
            ,'Y'
            ,'name'
            ,'population'
            ,'malusConquest'
            ,'typeClimate'
            ,'idNeighbor0'
            ,'idNeighbor1'
            ,'idNeighbor2'
            ,'idNeighbor3'
            ,'idNeighbor4'
            ,'idNeighbor5'
            ,'resources'
            ,'rivers'
            ,'foodProduction'
            ,'defenseBonus'
        ]));
    }

    public static function canDelete($bean)
    {
        return parent::canDelete($bean); // TODO: Change the autogenerated stub
    }

}