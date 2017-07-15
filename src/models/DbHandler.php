<?php
/**
 * Created by Manu
* Date: 2017-07-15
* Time: 12:29:12
 */

namespace Fr\Nj2\Api\models;

use Exception;
use Fr\Nj2\Api\models\collection\BaseCollection;

class DbHandler {

    /**
     * @var \mysqli
     */
    private static $conn = null;

    /**
     * @var array
     */
    private static $config;

    /**
     * Connecte à la base
     * @param $host
     * @param $db
     * @param $user
     * @param $pass
     * @return bool Succès de la connexion
     */
    public static function connect($host, $db, $user, $pass){
        self::$conn = new \mysqli($host, $user, $pass, $db);
        self::$conn->set_charset('utf8');
        return !self::$conn->connect_error;
    }

    /**
     * @param string $req La requête SQL
     * @param string $class La classe des objets dans la collection
     * @param string $coll La classe de la collection à renvoyer
     * @return BaseCollection
     */
    public static function collFromQuery($req,$class,$coll){
        $res = self::query($req);
        $coll =  'Fr\\Nj2\\Api\\models\\collection\\'.$coll;
        $ret = new $coll;
        while($obj = $res->fetch_object(__NAMESPACE__.'\\extended\\'.$class)) {
            $ret->append($obj);
        }
        return $ret;
    }

    /**
     * Renvoie le premier objet trouvé par la requête
     * @param string $req La requête SQL
     * @param string $class La classe de l'objet
     * @return Bean
     */
    public static function objFromQuery($req,$class){
        $res = self::query($req);
        $ret = null;
        while($obj = $res->fetch_object(__NAMESPACE__.'\\extended\\'.$class)) {
            $ret = $obj;
        }
        return $ret;
    }

    /**
     * @param string $req
     * @return int PK de l'objet créé
     */
    public static function insert($req){
        self::query($req);
        return self::$conn->insert_id;
    }

    /**
     * @param string $req
     * @return void
     */
    public static function update($req){
        self::query($req);
    }

    /**
     * @param string $req
     * @return void
     */
    public static function delete($req){
        self::query($req);
    }

    /**
    * @param $req
    * @return bool|\mysqli_result
    * @throws Exception
    */
    public static function query($req)
    {
        if(is_null(self::$conn)) {
            if(is_null(self::$config)) throw new Exception("Config parameters not initialized for connnection");
            if(!self::connect(self::$config['host'],self::$config['db'],self::$config['user'],self::$config['password'])) throw new Exception("Connection not possible : ".self::$conn->error);
        }
        return self::$conn->query($req);
    }

    /**
     * @param array $config
     */
    public static function setConfig($config)
    {
        self::$config = $config;
    }

    /**
     * @return \mysqli
     * @throws Exception
     */
    public static function getConn()
    {
        if(is_null(self::$conn)) {
        if(is_null(self::$config)) throw new Exception("Config parameters not initialized for connnection");
        if(!self::connect(self::$config['host'],self::$config['db'],self::$config['user'],self::$config['password'])) throw new Exception("Connection not possible : ".self::$conn->error);
        }
        return self::$conn;
    }

}