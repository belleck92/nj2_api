<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-15
 * Time: 12:29:11
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\TypeUnitMissionBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\TypeUnitMissionCollection;
use Fr\Nj2\Api\models\extended\TypeUnitMission;
use Fr\Nj2\Api\models\store\TypeUnitMissionStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\TypeUnitMissions as Right;

class TypeUnitMissions extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'typeUnitMission';

    public function getByIds($ids)
    {
        return $this->filterCollection(TypeUnitMissionStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new TypeUnitMissionCollection();
        foreach($queryBody as $typeUnitMissionData) {
            if(!isset($typeUnitMissionData['idTypeUnitMission'])) continue;
            if(Right::canWrite($typeUnitMissionData)) {
                $typeUnitMission = TypeUnitMissionStore::getById($typeUnitMissionData['idTypeUnitMission']);
                $typeUnitMission->edit(Right::writeableFields($typeUnitMissionData));
                $typeUnitMission->save();
                $ret->ajout($typeUnitMission);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new TypeUnitMissionCollection();
            foreach ($queryBody as $typeUnitMissionData) {
                if (isset($typeUnitMissionData['idTypeUnitMission'])) continue;
                
                if (Right::canWrite($typeUnitMissionData)) {
                    $typeUnitMission = new TypeUnitMission();
                    $typeUnitMission->edit(Right::writeableFields($typeUnitMissionData));
                    $typeUnitMission->save();
                    $ret->ajout($typeUnitMission);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = TypeUnitMissionStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = TypeUnitMissionBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new TypeUnitMissionCollection();
        foreach($ret as $typeUnitMission) {
            if(Right::canDelete($typeUnitMission)) $typeUnitMission->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(TypeUnitMissionBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $typeUnitMissions
     * @return array
     */
    public static function filterCollection(BaseCollection $typeUnitMissions)
    {
        $ret = [];
        foreach ($typeUnitMissions as $typeUnitMission) {
            if(Right::canSee($typeUnitMission)) $ret[] = Right::readableFields($typeUnitMission);
        }
        return $ret;
    }


}