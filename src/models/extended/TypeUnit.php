<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-09
 * Time: 16:40:03
 */

namespace Fr\Nj2\Api\models\extended;

use Exception;
use Fr\Nj2\Api\models\DbHandler;

class TypeUnit extends \Fr\Nj2\Api\models\TypeUnit
{
    const TYPE_ = 'TYPE_';

    /**
     * @var array
     */
    private static $storage;

    /**
     * @param string $fctId
     * @return TypeUnit
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
        $req = "SELECT * FROM typeUnit;";
        $res = DbHandler::query($req);
        while($line = mysqli_fetch_assoc($res)) {
            $typeUnit = new TypeUnit();
            $typeUnit->edit($line);
            self::$storage[$typeUnit->getFctId()] = $typeUnit;
        }
    }

}