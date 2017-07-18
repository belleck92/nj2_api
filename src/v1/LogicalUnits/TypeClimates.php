<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\TypeClimateBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\TypeClimateCollection;
use Fr\Nj2\Api\models\extended\TypeClimate;
use Fr\Nj2\Api\models\store\TypeClimateStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\TypeClimates as Right;
use Fr\Nj2\Api\v1\Extended\Hexas;
use Fr\Nj2\Api\v1\Extended\ProbaResourceClimates;

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
        $segments = explode('/', $queryString);
        if(count($segments) > 1) {
            switch ($segments[1]) {
                case 'hexas':
                    return Hexas::filterCollection(TypeClimateStore::getByIds($segments[0])->getHexas());
        
                case 'probaResourceClimates':
                    return ProbaResourceClimates::filterCollection(TypeClimateStore::getByIds($segments[0])->getProbaResourceClimates());
        }}
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
        } elseif (preg_match('#^[0-9]+$#', $segments[0])) {
            
            if($segments[1] == "hexas") {
                foreach ($queryBody as &$hexa) {
                    $hexa['idTypeClimate'] = $segments[0];
                }
                $unit = new Hexas();
                return $unit->create('', $parameters, $queryBody);
            }

            
            if($segments[1] == "probaResourceClimates") {
                foreach ($queryBody as &$probaResourceClimate) {
                    $probaResourceClimate['idTypeClimate'] = $segments[0];
                }
                $unit = new ProbaResourceClimates();
                return $unit->create('', $parameters, $queryBody);
            }

            
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