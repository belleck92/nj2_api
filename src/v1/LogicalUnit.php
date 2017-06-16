<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 16/06/17
 * Time: 13:28
 */

namespace fr\nj2\api\v1;


use fr\nj2\api\API;

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