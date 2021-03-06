<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\Bean;
use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\collection\BaseCollection;

abstract class BaseBusiness {

    /**
     * @var array
     */
    protected static $fields;

    /**
     * @var string
     */
    protected static $table;

    /**
     * Renvoie un objet
     * @param int $id PK de l'objet à trouver
     * @return Bean
     */
    public static function getById($id){
        return DbHandler::objFromQuery("SELECT * FROM `".static::$table."` WHERE `id".self::underscoreToCamelCase(static::$table)."` = ".$id.";",self::underscoreToCamelCase(static::$table));
    }

    /**
     * Renvoie une collection d'objets objet
     * @param string $ids PKs des objets à trouver (id1,id2,...)
     * @return BaseCollection
     */
    public static function getByIds($ids){
        return DbHandler::collFromQuery("SELECT * FROM `".static::$table."` WHERE `id".self::underscoreToCamelCase(static::$table)."` IN (".$ids.");",self::underscoreToCamelCase(static::$table), self::underscoreToCamelCase(static::$table).'Collection');
    }

    /**
     * Transforme une chaîne de type xxx_yyy en XxxYyy
     * @param string $str
     * @return string
     */
    public static function underscoreToCamelCase($str){
        $ret = '';
        $segments = explode('_', $str);
        foreach ($segments as $seg) $ret .= ucfirst($seg);
        return $ret;
    }

    /**
     * Enregistre l'objet en base
     * @param Bean $bean
     */
    public static function save(Bean $bean){
        if(is_null($bean->getId()) || $bean->getId() === 0) self::insert($bean);
        else self::update($bean);
    }

    /**
     * Crée le nouvel objet en base
     * @param Bean $bean
     */
    public static function insert(Bean $bean){
        $req = "INSERT INTO `".static::$table."`(";
        $prem = true;
        $firstField = true;
        foreach (static::$fields as $field) {
            if($firstField) {
                $firstField = false;
                continue;
            }
            if(!$prem) $req .= ',';
            $req .= '`'.$field.'`';
            $prem = false;
        }
        $req .= ") VALUES (";
        $prem = true;
        $firstField = true;
        foreach (static::$fields as $field) {
            if($firstField) {
                $firstField = false;
                continue;
            }
            if(!$prem) $req .= ',';
            $func = 'get'.self::underscoreToCamelCase($field);
            $req .= "'".mysqli_real_escape_string(DbHandler::getConn(), $bean->$func())."'";
            $prem = false;
        }
        $req .= ");";
        $bean->setId(DbHandler::insert($req));
    }

    /**
     * Met à jour l'objet en base
     * @param Bean $bean
     */
    public static function update(Bean $bean){
        $req = "UPDATE `".static::$table."` SET ";
        $prem = true;
        foreach (static::$fields as $field) {
            $func = 'get'.self::underscoreToCamelCase($field);
            if(!$prem) $req .= ',';
            $req .= '`'.$field ."` = '".mysqli_real_escape_string(DbHandler::getConn(), $bean->$func())."'" ;
            $prem = false;
        }
        $req .= " WHERE ".static::$fields[0]." = ".$bean->getId().";";
        DbHandler::update($req);
    }

    /**
     * @return array
     */
    public static function getFields()
    {
        return static::$fields;
    }

    /**
     * @return string
     */
    public static function getTable()
    {
        return static::$table;
    }

    /**
     * @param array $filters
     * @return BaseCollection
     */
    public static function getFiltered($filters)
    {
        $req = "SELECT * FROM `".static::$table."` ";
        if(count($filters)) {
            $req .= " WHERE ";
            $first = true;
            foreach ($filters as $field=>$val) {
                if(!$first) $req .= " AND ";
                $first = false;
                $req .= " `$field`='".DbHandler::getConn()->escape_string($val)."' ";
            }
        }
        $req .= ";";
        return DbHandler::collFromQuery($req,self::underscoreToCamelCase(static::$table), self::underscoreToCamelCase(static::$table).'Collection');
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

    /**
     * Returns all of the objects of the table
     */
    public static function getAll()
    {
        return DbHandler::collFromQuery("SELECT * FROM `".static::$table."`;",self::underscoreToCamelCase(static::$table), self::underscoreToCamelCase(static::$table).'Collection');
    }

}