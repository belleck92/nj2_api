<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-09
 * Time: 16:55:27
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\RiverBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\RiverCollection;
use Fr\Nj2\Api\models\extended\River;
use Fr\Nj2\Api\models\store\RiverStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Rivers as Right;

class Rivers extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'river';

    public function getByIds($ids)
    {
        return $this->filterCollection(RiverStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new RiverCollection();
        foreach($queryBody as $riverData) {
            if(!isset($riverData['idRiver'])) continue;
            if(Right::canWrite($riverData)) {
                $river = RiverStore::getById($riverData['idRiver']);
                $river->edit(Right::writeableFields($riverData));
                $river->save();
                $ret->ajout($river);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new RiverCollection();
            foreach ($queryBody as $riverData) {
                if (isset($riverData['idRiver'])) continue;
                
                if (Right::canWrite($riverData)) {
                    $river = new River();
                    $river->edit(Right::writeableFields($riverData));
                    $river->save();
                    $ret->ajout($river);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = RiverStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = RiverBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new RiverCollection();
        foreach($ret as $river) {
            if(Right::canDelete($river)) $river->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(RiverBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $rivers
     * @return array
     */
    public static function filterCollection(BaseCollection $rivers)
    {
        $ret = [];
        foreach ($rivers as $river) {
            if(Right::canSee($river)) $ret[] = Right::readableFields($river);
        }
        return $ret;
    }


}