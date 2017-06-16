<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 16/06/17
 * Time: 13:28
 */

namespace Fr\Nj2\Api\v1;

use Fr\Nj2\Api\API;

abstract class LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName;

    /**
     * @param $queryString
     * @param array $parameters
     * @return string
     */
    public function get($queryString, $parameters)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) {
            return $this->getByIds($queryString);
        } else {
            $segments = explode('/', $queryString);
            if($segments[0] == 'children') {

            }
        }
    }

    public abstract function getByIds($ids);
}