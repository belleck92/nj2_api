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
use Fr\Nj2\Api\models\store\UserStore;
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
        $segments = explode('/', $queryString);

        if(!$segments[0]) {
            if (!isset($queryBody['email']) || !isset($queryBody['password'])) {
                API::getInstance()->setErrorCode(1);
                API::getInstance()->setError('email and password fields mandatory');
                API::getInstance()->sendResponse(401);
            }
            $user = User::getByUserPassword($queryBody['email'], $queryBody['password']);
            if (is_null($user)) {
                API::getInstance()->setErrorCode(2);
                API::getInstance()->setError('user not found');
                API::getInstance()->sendResponse(401);
            }
            API::getInstance()->setToken(['idUser'=>$user->getId(), "role" => $user->getRole(), "idGame" => 1, "exp" => time() + 7200]);
            API::getInstance()->setJwtToken($this->encodeToken());
            return [];
            
        } elseif($segments[0] == 'connectToGame') {
            if (!isset($queryBody['idGame'])) {
                API::getInstance()->setErrorCode(3);
                API::getInstance()->setError('idGame field mandatory');
                API::getInstance()->sendResponse(401);
            }
            $token = API::getInstance()->getToken();
            if(!isset($token['idUser'])) {
                API::getInstance()->setErrorCode(4);
                API::getInstance()->setError('You must be already logged to connect to a game');
                API::getInstance()->sendResponse(404);
            }
            $user = UserStore::getById($token['idUser']);
            $selectedPlayer = null;
            foreach ($user->getPlayers() as $player) {
                if($player->getIdGame() == $queryBody['idGame']) {
                    $selectedPlayer = $player;
                }
            }

            if(is_null($selectedPlayer)) {
                API::getInstance()->setErrorCode(5);
                API::getInstance()->setError('User not in this game');
                API::getInstance()->sendResponse(404);
            }
            $token['idPlayer'] = $selectedPlayer->getId();
            $token['idCapitalCity'] = $selectedPlayer->getCapitalCity();
            API::getInstance()->setToken($token);
            API::getInstance()->setJwtToken($this->encodeToken());
            return [];
        }
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        API::getInstance()->sendResponse(404);
    }

    /**
     * @return string
     */
    private function encodeToken()
    {
        $header = base64_encode(json_encode(["typ" => "JWT", 'alg' => Config::ENCRYPTION_ALGO]));
        $payload = base64_encode(json_encode(API::getInstance()->getToken()));
        $signature = hash_hmac(Config::ENCRYPTION_ALGO, $header . '.' . $payload, Config::ENCRYPTION_KEY);
        return $header . '.' . $payload . '.' . $signature;
    }


}