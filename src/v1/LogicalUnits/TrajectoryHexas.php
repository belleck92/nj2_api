<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-12
 * Time: 11:44:57
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\TrajectoryHexaBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\TrajectoryHexaCollection;
use Fr\Nj2\Api\models\extended\TrajectoryHexa;
use Fr\Nj2\Api\models\store\TrajectoryHexaStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\TrajectoryHexas as Right;

class TrajectoryHexas extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'trajectoryHexa';

    public function getByIds($ids)
    {
        return $this->filterCollection(TrajectoryHexaStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new TrajectoryHexaCollection();
        foreach($queryBody as $trajectoryHexaData) {
            if(!isset($trajectoryHexaData['idTrajectoryHexa'])) continue;
            if(Right::canWrite($trajectoryHexaData)) {
                $trajectoryHexa = TrajectoryHexaStore::getById($trajectoryHexaData['idTrajectoryHexa']);
                $trajectoryHexa->edit(Right::writeableFields($trajectoryHexaData));
                $trajectoryHexa->save();
                $ret->ajout($trajectoryHexa);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new TrajectoryHexaCollection();
            foreach ($queryBody as $trajectoryHexaData) {
                if (isset($trajectoryHexaData['idTrajectoryHexa'])) continue;
                
                if (Right::canWrite($trajectoryHexaData)) {
                    $trajectoryHexa = new TrajectoryHexa();
                    $trajectoryHexa->edit(Right::writeableFields($trajectoryHexaData));
                    $trajectoryHexa->save();
                    $ret->ajout($trajectoryHexa);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = TrajectoryHexaStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = TrajectoryHexaBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new TrajectoryHexaCollection();
        foreach($ret as $trajectoryHexa) {
            if(Right::canDelete($trajectoryHexa)) $trajectoryHexa->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(TrajectoryHexaBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $trajectoryHexas
     * @return array
     */
    public static function filterCollection(BaseCollection $trajectoryHexas)
    {
        $ret = [];
        foreach ($trajectoryHexas as $trajectoryHexa) {
            if(Right::canSee($trajectoryHexa)) $ret[] = Right::readableFields($trajectoryHexa);
        }
        return $ret;
    }


}