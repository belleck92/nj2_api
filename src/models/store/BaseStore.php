<?php
/**
* Created by Manu
* Date: 2017-06-24
* Time: 14:27:39
*/
namespace Fr\Nj2\Api\models\store;

use Fr\Nj2\Api\models\Bean;
use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\ContactBusiness;
use Fr\Nj2\Api\models\business\SocieteBusiness;

abstract class BaseStore {

    private static $stock = array();
    private static $table;

    /**
     * @param int $id Id de l'objet à renvoyer
     * @return Bean
     */
    public static function getById($id){
        if(self::exists($id)) return self::$stock[static::$table][$id];
        else {
            $business =  'Fr\\Nj2\\Api\\models\\business\\'.BaseBusiness::underscoreToCamelCase(static::$table).'Business';
            self::$stock[static::$table][$id] = $business::getById($id);
        }
        return self::$stock[static::$table][$id];
    }

    /**
     * Vérifie si un Id d'objet est déjà storé
     * @param int $id
     * @return boolean
     */
    public static function exists($id){
        return isset(self::$stock[static::$table][$id]);
    }

    /**
     * Store l'objet
     * @param Bean $obj
     */
    public static function store(Bean $obj){
        self::$stock[static::$table][$obj->getId()] = $obj;
    }
}