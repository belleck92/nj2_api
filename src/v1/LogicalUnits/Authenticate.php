<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 18/06/17
 * Time: 17:25
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;


use Fr\Nj2\Api\API;
use Fr\Nj2\Api\Config\Config;
use Fr\Nj2\Api\models\Bean;
use Fr\Nj2\Api\v1\LogicalUnit;

class Authenticate extends LogicalUnit
{
    public function getByIds($ids)
    {
        API::getInstance()->sendResponse(404);
    }

    public static function readableFields(Bean $bean)
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

    public static function getFiltered($parameters)
    {
        API::getInstance()->sendResponse(404);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        if(isset($queryBody['user']) && $queryBody['user'] == "manu" && isset($queryBody['password']) && $queryBody['password'] == "zaza" ) {
            API::getInstance()->setToken(["role"=>API::ROLE_LOGGED, "idSociete"=>2, "exp"=>time()+7200]);
            $header = base64_encode(json_encode(["typ"=>"JWT", 'alg'=>Config::ENCRYPTION_ALGO]));
            $payload = base64_encode(json_encode(API::getInstance()->getToken()));
            $signature = hash_hmac(Config::ENCRYPTION_ALGO,$header.'.'.$payload, Config::ENCRYPTION_KEY);
            API::getInstance()->setJwtToken($header.'.'.$payload.'.'.$signature);
        } else API::getInstance()->sendResponse(401);
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        API::getInstance()->sendResponse(404);
    }


}