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

class TypeTreaty extends \Fr\Nj2\Api\models\TypeTreaty
{
    const TYPE_ = 'TYPE_';

    /**
     * @var array
     */
    private static $storage;

    /**
     * @param string $fctId
     * @return TypeTreaty
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
        $req = "SELECT * FROM typeTreaty;";
        $res = DbHandler::query($req);
        while($line = mysqli_fetch_assoc($res)) {
            $typeTreaty = new TypeTreaty();
            $typeTreaty->edit($line);
            self::$storage[$typeTreaty->getFctId()] = $typeTreaty;
        }
    }

}