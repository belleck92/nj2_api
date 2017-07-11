<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-11
 * Time: 17:23:57
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\TypeBuildingBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\TypeBuildingCollection;
use Fr\Nj2\Api\models\extended\TypeBuilding;
use Fr\Nj2\Api\models\store\TypeBuildingStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\TypeBuildings as Right;

class TypeBuildings extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'typeBuilding';

    public function getByIds($ids)
    {
        return $this->filterCollection(TypeBuildingStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new TypeBuildingCollection();
        foreach($queryBody as $typeBuildingData) {
            if(!isset($typeBuildingData['idTypeBuilding'])) continue;
            if(Right::canWrite($typeBuildingData)) {
                $typeBuilding = TypeBuildingStore::getById($typeBuildingData['idTypeBuilding']);
                $typeBuilding->edit(Right::writeableFields($typeBuildingData));
                $typeBuilding->save();
                $ret->ajout($typeBuilding);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new TypeBuildingCollection();
            foreach ($queryBody as $typeBuildingData) {
                if (isset($typeBuildingData['idTypeBuilding'])) continue;
                
                if (Right::canWrite($typeBuildingData)) {
                    $typeBuilding = new TypeBuilding();
                    $typeBuilding->edit(Right::writeableFields($typeBuildingData));
                    $typeBuilding->save();
                    $ret->ajout($typeBuilding);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = TypeBuildingStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = TypeBuildingBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new TypeBuildingCollection();
        foreach($ret as $typeBuilding) {
            if(Right::canDelete($typeBuilding)) $typeBuilding->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(TypeBuildingBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $typeBuildings
     * @return array
     */
    public static function filterCollection(BaseCollection $typeBuildings)
    {
        $ret = [];
        foreach ($typeBuildings as $typeBuilding) {
            if(Right::canSee($typeBuilding)) $ret[] = Right::readableFields($typeBuilding);
        }
        return $ret;
    }


}