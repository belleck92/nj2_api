<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-09
 * Time: 16:40:03
 */

namespace Fr\Nj2\Api\models\extended;

use Exception;
use Fr\Nj2\Api\models\collection\TypeClimateCollection;
use Fr\Nj2\Api\models\DbHandler;

class TypeClimate extends \Fr\Nj2\Api\models\TypeClimate
{
    const TYPE_SEA = 'TYPE_SEA';
    const TYPE_FLOE = 'TYPE_FLOE';
    const TYPE_ARCTIC = 'TYPE_ARCTIC';
    const TYPE_DESERT = 'TYPE_DESERT';
    const TYPE_PLAIN = 'TYPE_PLAIN';
    const TYPE_MEADOW = 'TYPE_MEADOW';
    const TYPE_FOREST = 'TYPE_FOREST';
    const TYPE_HILL = 'TYPE_HILL';
    const TYPE_FOREST_HILL = 'TYPE_FOREST_HILL';
    const TYPE_MOUNTAIN = 'TYPE_MOUNTAIN';

    /**
     * @var array
     */
    private static $storage;

    /**
     * @param string $fctId
     * @return TypeClimate
     * @throws Exception
     */
    public static function getByFctId($fctId)
    {
        if(is_null(self::$storage)) self::initTypes();
        if(!self::$storage[$fctId]) throw new Exception($fctId." type doesn't exists");
        return self::$storage[$fctId];
    }

    /**
     * Gets the types in database
     */
    public static function initTypes()
    {
        self::$storage = [];
        $req = "SELECT * FROM typeClimate;";
        $res = DbHandler::query($req);
        while($line = mysqli_fetch_assoc($res)) {
            $typeClimate = new TypeClimate();
            $typeClimate->edit($line);
            self::$storage[$typeClimate->getFctId()] = $typeClimate;
        }
    }
}