<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\TypeMissionBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\TypeMissionCollection;
use Fr\Nj2\Api\models\extended\TypeMission;
use Fr\Nj2\Api\models\store\TypeMissionStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\TypeMissions as Right;

class TypeMissions extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'typeMission';

    public function getByIds($ids)
    {
        return $this->filterCollection(TypeMissionStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new TypeMissionCollection();
        foreach($queryBody as $typeMissionData) {
            if(!isset($typeMissionData['idTypeMission'])) continue;
            if(Right::canWrite($typeMissionData)) {
                $typeMission = TypeMissionStore::getById($typeMissionData['idTypeMission']);
                $typeMission->edit(Right::writeableFields($typeMissionData));
                $typeMission->save();
                $ret->ajout($typeMission);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new TypeMissionCollection();
            foreach ($queryBody as $typeMissionData) {
                if (isset($typeMissionData['idTypeMission'])) continue;
                if (Right::canWrite($typeMissionData)) {
                    $typeMission = new TypeMission();
                    $typeMission->edit(Right::writeableFields($typeMissionData));
                    $typeMission->save();
                    $ret->ajout($typeMission);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = TypeMissionStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = TypeMissionBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new TypeMissionCollection();
        foreach($ret as $typeMission) {
            if(Right::canDelete($typeMission)) $typeMission->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(TypeMissionBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $typeMissions
     * @return array
     */
    public static function filterCollection(BaseCollection $typeMissions)
    {
        $ret = [];
        foreach ($typeMissions as $typeMission) {
            if(Right::canSee($typeMission)) $ret[] = Right::readableFields($typeMission);
        }
        return $ret;
    }


}