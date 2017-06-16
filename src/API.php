<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 15/06/17
 * Time: 18:57
 */

namespace fr\nj2\api;

use Exception;
use fr\nj2\api\v1\LogicalUnit;

class API
{
    public static function main()
    {
        $segments = explode('/',$_SERVER['REQUEST_URI']);
        if(preg_match('#^v[0-9]+$#',$segments[1])) {
            $version = $segments[1];
        } else throw new Exception("First segment of URL must be the version");
        
        $class = __NAMESPACE__.'\\'.$version.'\\LogicalUnits\\'.self::lowerToUpperCamelCase($segments[2]);
        if(!class_exists($class)) throw new Exception("Class ".$class." does not exist");
        $exec = new $class;/** @var LogicalUnit $exec */
        $queryString = substr($_SERVER['REQUEST_URI'],strlen($segments[1].$segments[2]) + 3);
        $queryString = substr($queryString,0, strpos($queryString, '?'));
        $parameters = $_GET;
        unset($parameters['_url']);

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                echo $exec->get($queryString, $parameters);
                break;
            case 'PUT':

                break;
            case 'POST':

                break;
            case 'DELETE':

                break;
            default :
                throw new Exception("HTTP method ".$_SERVER['REQUEST_METHOD']." not handled");
        }

        echo "\n";

    }

    /**
     * @param string $str
     * @return string
     */
    public static function lowerToUpperCamelCase($str)
    {
        return strtoupper(substr($str,0,1)).substr($str,1,strlen($str)-1);
    }
    
    /**
     * @param string $str
     * @return string
     */
    public static function upperToLowerCamelCase($str)
    {
        return strtolower(substr($str,0,1)).substr($str,1,strlen($str)-1);
    }
}