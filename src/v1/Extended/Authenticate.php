<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 18/07/17
 * Time: 12:32
 */

namespace Fr\Nj2\Api\v1\Extended;


use Fr\Nj2\Api\API;
use Fr\Nj2\Api\Config\Config;
use Fr\Nj2\Api\models\Bean;
use Fr\Nj2\Api\models\extended\User;
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
        if(!isset($queryBody['email']) || !isset($queryBody['password'])) {
            API::getInstance()->setErrorCode(1);
            API::getInstance()->setError('email and password fields mandatory');
            API::getInstance()->sendResponse(401);
        }
        $user = User::getByUserPassword($queryBody['email'],$queryBody['password']);
        if(is_null($user)){
            API::getInstance()->setErrorCode(2);
            API::getInstance()->setError('user not found');
            API::getInstance()->sendResponse(401);
        }
        API::getInstance()->setToken(["role"=>$user->getRole(), "idGame"=>1, "exp"=>time()+7200]);
        $header = base64_encode(json_encode(["typ"=>"JWT", 'alg'=>Config::ENCRYPTION_ALGO]));
        $payload = base64_encode(json_encode(API::getInstance()->getToken()));
        $signature = hash_hmac(Config::ENCRYPTION_ALGO,$header.'.'.$payload, Config::ENCRYPTION_KEY);
        API::getInstance()->setJwtToken($header.'.'.$payload.'.'.$signature);
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        API::getInstance()->sendResponse(404);
    }


}