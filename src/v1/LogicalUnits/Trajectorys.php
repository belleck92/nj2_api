<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-15
 * Time: 12:29:11
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\TrajectoryBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\TrajectoryCollection;
use Fr\Nj2\Api\models\extended\Trajectory;
use Fr\Nj2\Api\models\store\TrajectoryStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Trajectorys as Right;

class Trajectorys extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'trajectory';

    public function getByIds($ids)
    {
        return $this->filterCollection(TrajectoryStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new TrajectoryCollection();
        foreach($queryBody as $trajectoryData) {
            if(!isset($trajectoryData['idTrajectory'])) continue;
            if(Right::canWrite($trajectoryData)) {
                $trajectory = TrajectoryStore::getById($trajectoryData['idTrajectory']);
                $trajectory->edit(Right::writeableFields($trajectoryData));
                $trajectory->save();
                $ret->ajout($trajectory);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new TrajectoryCollection();
            foreach ($queryBody as $trajectoryData) {
                if (isset($trajectoryData['idTrajectory'])) continue;
                
                if (Right::canWrite($trajectoryData)) {
                    $trajectory = new Trajectory();
                    $trajectory->edit(Right::writeableFields($trajectoryData));
                    $trajectory->save();
                    $ret->ajout($trajectory);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = TrajectoryStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = TrajectoryBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new TrajectoryCollection();
        foreach($ret as $trajectory) {
            if(Right::canDelete($trajectory)) $trajectory->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(TrajectoryBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $trajectorys
     * @return array
     */
    public static function filterCollection(BaseCollection $trajectorys)
    {
        $ret = [];
        foreach ($trajectorys as $trajectory) {
            if(Right::canSee($trajectory)) $ret[] = Right::readableFields($trajectory);
        }
        return $ret;
    }


}