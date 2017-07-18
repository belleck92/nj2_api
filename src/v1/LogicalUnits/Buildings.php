<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\BuildingBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\BuildingCollection;
use Fr\Nj2\Api\models\extended\Building;
use Fr\Nj2\Api\models\store\BuildingStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Buildings as Right;

class Buildings extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'building';

    public function getByIds($ids)
    {
        return $this->filterCollection(BuildingStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new BuildingCollection();
        foreach($queryBody as $buildingData) {
            if(!isset($buildingData['idBuilding'])) continue;
            if(Right::canWrite($buildingData)) {
                $building = BuildingStore::getById($buildingData['idBuilding']);
                $building->edit(Right::writeableFields($buildingData));
                $building->save();
                $ret->ajout($building);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new BuildingCollection();
            foreach ($queryBody as $buildingData) {
                if (isset($buildingData['idBuilding'])) continue;
                
                if (Right::canWrite($buildingData)) {
                    $building = new Building();
                    $building->edit(Right::writeableFields($buildingData));
                    $building->save();
                    $ret->ajout($building);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = BuildingStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = BuildingBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new BuildingCollection();
        foreach($ret as $building) {
            if(Right::canDelete($building)) $building->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(BuildingBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $buildings
     * @return array
     */
    public static function filterCollection(BaseCollection $buildings)
    {
        $ret = [];
        foreach ($buildings as $building) {
            if(Right::canSee($building)) $ret[] = Right::readableFields($building);
        }
        return $ret;
    }


}