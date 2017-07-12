<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-12
 * Time: 11:44:57
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\TypeBonusBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\TypeBonusCollection;
use Fr\Nj2\Api\models\extended\TypeBonus;
use Fr\Nj2\Api\models\store\TypeBonusStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\TypeBonuss as Right;

class TypeBonuss extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'typeBonus';

    public function getByIds($ids)
    {
        return $this->filterCollection(TypeBonusStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new TypeBonusCollection();
        foreach($queryBody as $typeBonusData) {
            if(!isset($typeBonusData['idTypeBonus'])) continue;
            if(Right::canWrite($typeBonusData)) {
                $typeBonus = TypeBonusStore::getById($typeBonusData['idTypeBonus']);
                $typeBonus->edit(Right::writeableFields($typeBonusData));
                $typeBonus->save();
                $ret->ajout($typeBonus);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new TypeBonusCollection();
            foreach ($queryBody as $typeBonusData) {
                if (isset($typeBonusData['idTypeBonus'])) continue;
                
                if (Right::canWrite($typeBonusData)) {
                    $typeBonus = new TypeBonus();
                    $typeBonus->edit(Right::writeableFields($typeBonusData));
                    $typeBonus->save();
                    $ret->ajout($typeBonus);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = TypeBonusStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = TypeBonusBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new TypeBonusCollection();
        foreach($ret as $typeBonus) {
            if(Right::canDelete($typeBonus)) $typeBonus->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(TypeBonusBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $typeBonuss
     * @return array
     */
    public static function filterCollection(BaseCollection $typeBonuss)
    {
        $ret = [];
        foreach ($typeBonuss as $typeBonus) {
            if(Right::canSee($typeBonus)) $ret[] = Right::readableFields($typeBonus);
        }
        return $ret;
    }


}