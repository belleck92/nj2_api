<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 03/07/17
 * Time: 14:02
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;


use Fr\Nj2\Api\API;
use Fr\Nj2\Api\v1\LogicalUnit;

class Map extends LogicalUnit
{
    /**
     * @var bool
     */
    protected static $canWorkWithoutToken = true;

    /**
     * @param string $ids
     * @return array
     */
    public function getByIds($ids)
    {
        API::getInstance()->sendResponse(404);
    }

    public function get($queryString, $parameters)
    {
        
    }

}