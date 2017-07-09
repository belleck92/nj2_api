<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-09
 * Time: 16:55:27
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\TypeUnitBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\TypeUnitCollection;
use Fr\Nj2\Api\models\extended\TypeUnit;
use Fr\Nj2\Api\models\store\TypeUnitStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\TypeUnits as Right;

class TypeUnits extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'typeUnit';

    public function getByIds($ids)
    {
        return $this->filterCollection(TypeUnitStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new TypeUnitCollection();
        foreach($queryBody as $typeUnitData) {
            if(!isset($typeUnitData['idTypeUnit'])) continue;
            if(Right::canWrite($typeUnitData)) {
                $typeUnit = TypeUnitStore::getById($typeUnitData['idTypeUnit']);
                $typeUnit->edit(Right::writeableFields($typeUnitData));
                $typeUnit->save();
                $ret->ajout($typeUnit);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new TypeUnitCollection();
            foreach ($queryBody as $typeUnitData) {
                if (isset($typeUnitData['idTypeUnit'])) continue;
                
                if (Right::canWrite($typeUnitData)) {
                    $typeUnit = new TypeUnit();
                    $typeUnit->edit(Right::writeableFields($typeUnitData));
                    $typeUnit->save();
                    $ret->ajout($typeUnit);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = TypeUnitStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = TypeUnitBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new TypeUnitCollection();
        foreach($ret as $typeUnit) {
            if(Right::canDelete($typeUnit)) $typeUnit->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(TypeUnitBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $typeUnits
     * @return array
     */
    public static function filterCollection(BaseCollection $typeUnits)
    {
        $ret = [];
        foreach ($typeUnits as $typeUnit) {
            if(Right::canSee($typeUnit)) $ret[] = Right::readableFields($typeUnit);
        }
        return $ret;
    }


}