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

class TypeTech extends \Fr\Nj2\Api\models\TypeTech
{
    const TYPE_ = 'TYPE_';

    /**
     * @var array
     */
    private static $storage;

    /**
     * @param string $fctId
     * @return TypeTech
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
        $req = "SELECT * FROM typeTech;";
        $res = DbHandler::query($req);
        while($line = mysqli_fetch_assoc($res)) {
            $typeTech = new TypeTech();
            $typeTech->edit($line);
            self::$storage[$typeTech->getFctId()] = $typeTech;
        }
    }

}