<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 16/06/17
 * Time: 13:28
 */

namespace Fr\Nj2\Api\v1;


use Fr\Nj2\Api\API;

class LogicalUnit
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
            $req = "SELECT * FROM ".$this->tableName." WHERE id".API::lowerToUpperCamelCase($this->tableName)." IN (".$queryString.");";
            return $req;
        } else {
            $segments = explode('/', $queryString);
            if($segments[0] == 'children') {

            }
        }
    }
}