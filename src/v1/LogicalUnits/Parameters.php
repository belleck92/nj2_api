<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\ParameterBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\ParameterCollection;
use Fr\Nj2\Api\models\extended\Parameter;
use Fr\Nj2\Api\models\store\ParameterStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Parameters as Right;

class Parameters extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'parameter';

    public function getByIds($ids)
    {
        return $this->filterCollection(ParameterStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new ParameterCollection();
        foreach($queryBody as $parameterData) {
            if(!isset($parameterData['idParameter'])) continue;
            if(Right::canWrite($parameterData)) {
                $parameter = ParameterStore::getById($parameterData['idParameter']);
                $parameter->edit(Right::writeableFields($parameterData));
                $parameter->save();
                $ret->ajout($parameter);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new ParameterCollection();
            foreach ($queryBody as $parameterData) {
                if (isset($parameterData['idParameter'])) continue;
                
                if (Right::canWrite($parameterData)) {
                    $parameter = new Parameter();
                    $parameter->edit(Right::writeableFields($parameterData));
                    $parameter->save();
                    $ret->ajout($parameter);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = ParameterStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = ParameterBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new ParameterCollection();
        foreach($ret as $parameter) {
            if(Right::canDelete($parameter)) $parameter->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(ParameterBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $parameters
     * @return array
     */
    public static function filterCollection(BaseCollection $parameters)
    {
        $ret = [];
        foreach ($parameters as $parameter) {
            if(Right::canSee($parameter)) $ret[] = Right::readableFields($parameter);
        }
        return $ret;
    }


}