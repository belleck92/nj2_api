<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 18/06/17
 * Time: 17:25
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;


use Fr\Nj2\Api\API;
use Fr\Nj2\Api\models\Bean;
use Fr\Nj2\Api\v1\LogicalUnit;

class Authenticate extends LogicalUnit
{
    public function getByIds($ids)
    {
        API::getInstance()->sendResponse(404);
    }

    public function fields(Bean $bean)
    {
        API::getInstance()->sendResponse(404);
    }

    public function get($queryString, $parameters)
    {
        API::getInstance()->sendResponse(404);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        API::getInstance()->sendResponse(404);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        // todo real password testing and real values in token
        if(isset($queryBody['user']) && $queryBody['user'] == "manu" && isset($queryBody['password']) && $queryBody['password'] == "zaza" ) {
            API::getInstance()->setToken(["role"=>API::ROLE_LOGGED, "idSociete"=>1, "exp"=>time()+7200]);
        } else API::getInstance()->sendResponse(401);
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        API::getInstance()->sendResponse(404);
    }


}