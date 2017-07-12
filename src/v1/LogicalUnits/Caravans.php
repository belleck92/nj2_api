<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-12
 * Time: 11:44:57
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\CaravanBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\CaravanCollection;
use Fr\Nj2\Api\models\extended\Caravan;
use Fr\Nj2\Api\models\store\CaravanStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Caravans as Right;

class Caravans extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'caravan';

    public function getByIds($ids)
    {
        return $this->filterCollection(CaravanStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new CaravanCollection();
        foreach($queryBody as $caravanData) {
            if(!isset($caravanData['idCaravan'])) continue;
            if(Right::canWrite($caravanData)) {
                $caravan = CaravanStore::getById($caravanData['idCaravan']);
                $caravan->edit(Right::writeableFields($caravanData));
                $caravan->save();
                $ret->ajout($caravan);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new CaravanCollection();
            foreach ($queryBody as $caravanData) {
                if (isset($caravanData['idCaravan'])) continue;
                
                if (Right::canWrite($caravanData)) {
                    $caravan = new Caravan();
                    $caravan->edit(Right::writeableFields($caravanData));
                    $caravan->save();
                    $ret->ajout($caravan);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = CaravanStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = CaravanBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new CaravanCollection();
        foreach($ret as $caravan) {
            if(Right::canDelete($caravan)) $caravan->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(CaravanBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $caravans
     * @return array
     */
    public static function filterCollection(BaseCollection $caravans)
    {
        $ret = [];
        foreach ($caravans as $caravan) {
            if(Right::canSee($caravan)) $ret[] = Right::readableFields($caravan);
        }
        return $ret;
    }


}