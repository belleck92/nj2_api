<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\HqBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\HqCollection;
use Fr\Nj2\Api\models\extended\Hq;
use Fr\Nj2\Api\models\store\HqStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Hqs as Right;

class Hqs extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'hq';

    public function getByIds($ids)
    {
        return $this->filterCollection(HqStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new HqCollection();
        foreach($queryBody as $hqData) {
            if(!isset($hqData['idHq'])) continue;
            if(Right::canWrite($hqData)) {
                $hq = HqStore::getById($hqData['idHq']);
                $hq->edit(Right::writeableFields($hqData));
                $hq->save();
                $ret->ajout($hq);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new HqCollection();
            foreach ($queryBody as $hqData) {
                if (isset($hqData['idHq'])) continue;
                if (Right::canWrite($hqData)) {
                    $hq = new Hq();
                    $hq->edit(Right::writeableFields($hqData));
                    $hq->save();
                    $ret->ajout($hq);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = HqStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = HqBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new HqCollection();
        foreach($ret as $hq) {
            if(Right::canDelete($hq)) $hq->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(HqBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $hqs
     * @return array
     */
    public static function filterCollection(BaseCollection $hqs)
    {
        $ret = [];
        foreach ($hqs as $hq) {
            if(Right::canSee($hq)) $ret[] = Right::readableFields($hq);
        }
        return $ret;
    }


}