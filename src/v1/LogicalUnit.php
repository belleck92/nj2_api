<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-12
 * Time: 11:44:57
 */

namespace Fr\Nj2\Api\v1;

use Fr\Nj2\Api\models\Bean;

abstract class LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName;

    /**
     * @var bool
     */
    protected $canWorkWithoutToken = false;

    /**
     * @param string $queryString
     * @param array $parameters
     * @return array
     */
    public function get($queryString, $parameters)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) {
            return $this->getByIds($queryString);
        } elseif($queryString == 'filter') {
            return $this->getFiltered($parameters);
        } else return[];
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters) {
        return [];
    }

    /**
     * @param string $queryString
     * @param array $parameters
     * @param array $queryBody
     * @return string
     */
    public function update($queryString, $parameters, $queryBody)
    {

    }

    /**
     * @param string $queryString
     * @param array $parameters
     * @param array $queryBody
     * @return string
     */
    public function create($queryString, $parameters, $queryBody)
    {

    }

    /**
     * @param string $queryString
     * @param array $parameters
     * @param array $queryBody
     * @return string
     */
    public function delete($queryString, $parameters, $queryBody)
    {
       
    }

    /**
     * @param string $ids
     * @return array
     */
    public abstract function getByIds($ids);

    /**
     * @param Bean $bean
     * @return bool
     */
    public static function canSee(Bean $bean)
    {
        return false;
    }

    /**
     * Returns the fields to be displayed
     * @param Bean $bean
     * @return array
     */
    public static function readableFields(Bean $bean){
        return [];
    }

    /**
     * @param array $data
     * @return bool
     */
    public static function canWrite($data)
    {
        return false;
    }

    /**
     * Returns the fields that can be written
     * @param array $data
     * @return array
     */
    public static function writeableFields($data){
        return [];
    }

    /**
     * @return bool
     */
    public function canWorkWithoutToken() {
        return $this->canWorkWithoutToken;
    }
}