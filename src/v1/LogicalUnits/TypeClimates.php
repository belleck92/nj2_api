<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-07
 * Time: 17:53:41
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\TypeClimateBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\TypeClimateCollection;
use Fr\Nj2\Api\models\TypeClimate;
use Fr\Nj2\Api\models\store\TypeClimateStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\TypeClimates as Right;

class TypeClimates extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'typeClimate';

    public function getByIds($ids)
    {
        return $this->filterCollection(TypeClimateStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new TypeClimateCollection();
        foreach($queryBody as $typeClimateData) {
            if(!isset($typeClimateData['idTypeClimate'])) continue;
            if(Right::canWrite($typeClimateData)) {
                $typeClimate = TypeClimateStore::getById($typeClimateData['idTypeClimate']);
                $typeClimate->edit(Right::writeableFields($typeClimateData));
                $typeClimate->save();
                $ret->ajout($typeClimate);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new TypeClimateCollection();
            foreach ($queryBody as $typeClimateData) {
                if (isset($typeClimateData['idTypeClimate'])) continue;
                
                if (Right::canWrite($typeClimateData)) {
                    $typeClimate = new TypeClimate();
                    $typeClimate->edit(Right::writeableFields($typeClimateData));
                    $typeClimate->save();
                    $ret->ajout($typeClimate);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = TypeClimateStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = TypeClimateBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new TypeClimateCollection();
        foreach($ret as $typeClimate) {
            if(Right::canDelete($typeClimate)) $typeClimate->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(TypeClimateBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $typeClimates
     * @return array
     */
    public static function filterCollection(BaseCollection $typeClimates)
    {
        $ret = [];
        foreach ($typeClimates as $typeClimate) {
            if(Right::canSee($typeClimate)) $ret[] = Right::readableFields($typeClimate);
        }
        return $ret;
    }


}