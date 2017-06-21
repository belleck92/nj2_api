<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 16/06/17
 * Time: 13:28
 */

namespace Fr\Nj2\Api\v1;

use Fr\Nj2\Api\API;
use Fr\Nj2\Api\models\Bean;

abstract class LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName;

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
     * Returns the fields to be displayed
     * @param Bean $bean
     * @return array
     */
    public static function fields(Bean $bean){
        return [];
    }
}