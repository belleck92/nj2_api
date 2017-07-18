<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\ProbaResourceClimateBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\ProbaResourceClimateCollection;
use Fr\Nj2\Api\models\extended\ProbaResourceClimate;
use Fr\Nj2\Api\models\store\ProbaResourceClimateStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\ProbaResourceClimates as Right;
use Fr\Nj2\Api\v1\Extended\TypeClimates;
use Fr\Nj2\Api\v1\Extended\TypeResources;

class ProbaResourceClimates extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'probaResourceClimate';

    public function getByIds($ids)
    {
        return $this->filterCollection(ProbaResourceClimateStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        $segments = explode('/', $queryString);
        if(count($segments) > 1) {
            switch ($segments[1]) {
                case 'typeClimates':
                    return TypeClimates::filterCollection(ProbaResourceClimateStore::getByIds($segments[0])->getTypeClimates());
            
                case 'typeResources':
                    return TypeResources::filterCollection(ProbaResourceClimateStore::getByIds($segments[0])->getTypeResources());
            }}
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new ProbaResourceClimateCollection();
        foreach($queryBody as $probaResourceClimateData) {
            if(!isset($probaResourceClimateData['idProbaResourceClimate'])) continue;
            if(Right::canWrite($probaResourceClimateData)) {
                $probaResourceClimate = ProbaResourceClimateStore::getById($probaResourceClimateData['idProbaResourceClimate']);
                $probaResourceClimate->edit(Right::writeableFields($probaResourceClimateData));
                $probaResourceClimate->save();
                $ret->ajout($probaResourceClimate);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new ProbaResourceClimateCollection();
            foreach ($queryBody as $probaResourceClimateData) {
                if (isset($probaResourceClimateData['idProbaResourceClimate'])) continue;
                if (!isset($probaResourceClimateData['idTypeClimate'])) continue;if (!isset($probaResourceClimateData['idTypeResource'])) continue;
                if (Right::canWrite($probaResourceClimateData)) {
                    $probaResourceClimate = new ProbaResourceClimate();
                    $probaResourceClimate->edit(Right::writeableFields($probaResourceClimateData));
                    $probaResourceClimate->save();
                    $ret->ajout($probaResourceClimate);
                }
            }
            return $this->filterCollection($ret);
        } elseif (preg_match('#^[0-9]+$#', $segments[0])) {
            if($segments[1] == "typeClimates") {
                $unit = new TypeClimates();
                $unit->create('', $parameters, $queryBody);
            }if($segments[1] == "typeResources") {
                $unit = new TypeResources();
                $unit->create('', $parameters, $queryBody);
            }
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = ProbaResourceClimateStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = ProbaResourceClimateBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new ProbaResourceClimateCollection();
        foreach($ret as $probaResourceClimate) {
            if(Right::canDelete($probaResourceClimate)) $probaResourceClimate->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(ProbaResourceClimateBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $probaResourceClimates
     * @return array
     */
    public static function filterCollection(BaseCollection $probaResourceClimates)
    {
        $ret = [];
        foreach ($probaResourceClimates as $probaResourceClimate) {
            if(Right::canSee($probaResourceClimate)) $ret[] = Right::readableFields($probaResourceClimate);
        }
        return $ret;
    }


}