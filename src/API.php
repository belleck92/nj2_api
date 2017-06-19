<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 15/06/17
 * Time: 18:57
 */

namespace Fr\Nj2\Api;

use Exception;
use Fr\Nj2\Api\Config\Config;
use Fr\Nj2\Api\v1\LogicalUnit;

class API
{
    const ROLE_ADMIN = 1;
    const ROLE_LOGGED = 2;
    const ROLE_PLAYER = 3;
    const ROLE_UNLOGGED = 4;

    private $errorCode = 0;
    private $error = '';

    private $token = [];
    private $jwtToken;

    private $returnedData = [];

    /**
     * @var API
     */
    private static $instance;

    /**
     * @return API
     */
    public static function getInstance()
    {
        if(is_null(self::$instance)) self::$instance = new API();
        return self::$instance;
    }

    public function main()
    {
        /*
         * URI Parameters
         */
        $segments = explode('/',$_SERVER['REQUEST_URI']);
        if(preg_match('#^v[0-9]+$#',$segments[1])) {
            $version = $segments[1];
        } else throw new Exception("First segment of URL must be the version");
        
        $class = __NAMESPACE__.'\\'.$version.'\\LogicalUnits\\'.self::lowerToUpperCamelCase($segments[2]);
        if(!class_exists($class)) $this->sendResponse(404);
        $exec = new $class;/** @var LogicalUnit $exec */
        $queryString = substr($_SERVER['REQUEST_URI'],strlen($segments[1].$segments[2]) + 3);
        if(strpos($queryString, '?') !== false) $queryString = substr($queryString,0, strpos($queryString, '?'));
        $parameters = $_GET;
        unset($parameters['_url']);

        /*
         * Token handling
         */
        if(strtolower($segments[2]) != 'authenticate') {
            if(isset(\getallheaders()['Authorization'])) {
                if(preg_match('#^Bearer (.*)$#', \getallheaders()['Authorization'])) {
                    $token = preg_replace('#^Bearer (.*)$#', '$1', \getallheaders()['Authorization']);
                    $this->jwtToken = $token;
                    $segments = explode('.', $token);
                    if(count($segments) == 3) {
                        $signature = hash_hmac(Config::ENCRYPTION_ALGO,$segments[0].'.'.$segments[1], Config::ENCRYPTION_KEY);
                        if($signature == $segments[2]) {
                            $this->token = json_decode(base64_decode($segments[1]), true);
                        } else {
                            $this->sendResponse(401);
                        }
                    } else {
                        $this->sendResponse(401);
                    }
                } else {
                    $this->sendResponse(401);
                }
            } else {
                $this->sendResponse(401);
            }
        }

        /*
         * Request processing
         */
        $this->returnedData = [];
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->returnedData = $exec->get($queryString, $parameters);
                break;
            case 'PUT':
                $this->returnedData = $exec->update($queryString, $parameters, json_decode(file_get_contents('php://input'), true));
                break;
            case 'POST':
                $this->returnedData = $exec->create($queryString, $parameters, json_decode(file_get_contents('php://input'), true));
                break;
            case 'DELETE':
                $this->returnedData = $exec->delete($queryString, $parameters, json_decode(file_get_contents('php://input'), true));
                break;
            default :
                throw new Exception("HTTP method " . $_SERVER['REQUEST_METHOD'] . " not handled");
        }
        $this->sendResponse();
    }

    /**
     * Send the http response
     * @param int $code HTTP response code
     */
    public function sendResponse($code = 200)
    {
        http_response_code($code);
        if($code == 200) {
            echo json_encode([
                'error'=>$this->getErrorData()
                ,'data'=>$this->returnedData
                ,'token'=>$this->getJWTToken()
            ]);
        }
        exit();
    }

    /**
     * @return array
     */
    public function getErrorData()
    {
        return ['code'=>$this->errorCode, 'desc'=>$this->error];
    }

    /**
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param int $errorCode
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * Returns the data in the payload of the token
     * @return array
     */
    public function getToken()
    {
        if(empty($this->token)) return ['role'=>self::ROLE_UNLOGGED];
        else return $this->token;
    }

    /**
     * @param mixed $jwtToken
     */
    public function setJwtToken($jwtToken)
    {
        $this->jwtToken = $jwtToken;
    }

    /**
     * @return mixed
     */
    public function getJwtToken()
    {
        return $this->jwtToken;
    }

    /**
     * @param array $token
     */
    public function setToken($token)
    {
        $this->token = $token;
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