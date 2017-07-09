<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-09
 * Time: 16:55:27
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\SpyBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\SpyCollection;
use Fr\Nj2\Api\models\extended\Spy;
use Fr\Nj2\Api\models\store\SpyStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Spys as Right;

class Spys extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'spy';

    public function getByIds($ids)
    {
        return $this->filterCollection(SpyStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new SpyCollection();
        foreach($queryBody as $spyData) {
            if(!isset($spyData['idSpy'])) continue;
            if(Right::canWrite($spyData)) {
                $spy = SpyStore::getById($spyData['idSpy']);
                $spy->edit(Right::writeableFields($spyData));
                $spy->save();
                $ret->ajout($spy);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new SpyCollection();
            foreach ($queryBody as $spyData) {
                if (isset($spyData['idSpy'])) continue;
                
                if (Right::canWrite($spyData)) {
                    $spy = new Spy();
                    $spy->edit(Right::writeableFields($spyData));
                    $spy->save();
                    $ret->ajout($spy);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = SpyStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = SpyBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new SpyCollection();
        foreach($ret as $spy) {
            if(Right::canDelete($spy)) $spy->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(SpyBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $spys
     * @return array
     */
    public static function filterCollection(BaseCollection $spys)
    {
        $ret = [];
        foreach ($spys as $spy) {
            if(Right::canSee($spy)) $ret[] = Right::readableFields($spy);
        }
        return $ret;
    }


}