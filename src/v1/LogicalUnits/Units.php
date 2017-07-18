<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\UnitBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\UnitCollection;
use Fr\Nj2\Api\models\extended\Unit;
use Fr\Nj2\Api\models\store\UnitStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Units as Right;

class Units extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'unit';

    public function getByIds($ids)
    {
        return $this->filterCollection(UnitStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new UnitCollection();
        foreach($queryBody as $unitData) {
            if(!isset($unitData['idUnit'])) continue;
            if(Right::canWrite($unitData)) {
                $unit = UnitStore::getById($unitData['idUnit']);
                $unit->edit(Right::writeableFields($unitData));
                $unit->save();
                $ret->ajout($unit);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new UnitCollection();
            foreach ($queryBody as $unitData) {
                if (isset($unitData['idUnit'])) continue;
                
                if (Right::canWrite($unitData)) {
                    $unit = new Unit();
                    $unit->edit(Right::writeableFields($unitData));
                    $unit->save();
                    $ret->ajout($unit);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = UnitStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = UnitBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new UnitCollection();
        foreach($ret as $unit) {
            if(Right::canDelete($unit)) $unit->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(UnitBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $units
     * @return array
     */
    public static function filterCollection(BaseCollection $units)
    {
        $ret = [];
        foreach ($units as $unit) {
            if(Right::canSee($unit)) $ret[] = Right::readableFields($unit);
        }
        return $ret;
    }


}