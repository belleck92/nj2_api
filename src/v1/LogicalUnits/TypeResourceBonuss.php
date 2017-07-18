<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\TypeResourceBonusBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\TypeResourceBonusCollection;
use Fr\Nj2\Api\models\extended\TypeResourceBonus;
use Fr\Nj2\Api\models\store\TypeResourceBonusStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\TypeResourceBonuss as Right;

class TypeResourceBonuss extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'typeResourceBonus';

    public function getByIds($ids)
    {
        return $this->filterCollection(TypeResourceBonusStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new TypeResourceBonusCollection();
        foreach($queryBody as $typeResourceBonusData) {
            if(!isset($typeResourceBonusData['idTypeResourceBonus'])) continue;
            if(Right::canWrite($typeResourceBonusData)) {
                $typeResourceBonus = TypeResourceBonusStore::getById($typeResourceBonusData['idTypeResourceBonus']);
                $typeResourceBonus->edit(Right::writeableFields($typeResourceBonusData));
                $typeResourceBonus->save();
                $ret->ajout($typeResourceBonus);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new TypeResourceBonusCollection();
            foreach ($queryBody as $typeResourceBonusData) {
                if (isset($typeResourceBonusData['idTypeResourceBonus'])) continue;
                if (Right::canWrite($typeResourceBonusData)) {
                    $typeResourceBonus = new TypeResourceBonus();
                    $typeResourceBonus->edit(Right::writeableFields($typeResourceBonusData));
                    $typeResourceBonus->save();
                    $ret->ajout($typeResourceBonus);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = TypeResourceBonusStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = TypeResourceBonusBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new TypeResourceBonusCollection();
        foreach($ret as $typeResourceBonus) {
            if(Right::canDelete($typeResourceBonus)) $typeResourceBonus->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(TypeResourceBonusBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $typeResourceBonuss
     * @return array
     */
    public static function filterCollection(BaseCollection $typeResourceBonuss)
    {
        $ret = [];
        foreach ($typeResourceBonuss as $typeResourceBonus) {
            if(Right::canSee($typeResourceBonus)) $ret[] = Right::readableFields($typeResourceBonus);
        }
        return $ret;
    }


}