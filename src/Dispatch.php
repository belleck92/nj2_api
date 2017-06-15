<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 15/06/17
 * Time: 18:57
 */

namespace fr\nj2\api;

use Exception;

class Dispatch
{
    public static function main()
    {
        $segments = explode('/',$_SERVER['REQUEST_URI']);
        if(preg_match('#^v[0-9]+$#',$segments[1])) {

        } else throw new Exception("First segment of URL must be the version");
    }
}