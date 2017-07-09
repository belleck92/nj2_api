<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-09
 * Time: 16:55:27
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\TypeResourceBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\TypeResourceCollection;
use Fr\Nj2\Api\models\extended\TypeResource;
use Fr\Nj2\Api\models\store\TypeResourceStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\TypeResources as Right;

class TypeResources extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'typeResource';

    public function getByIds($ids)
    {
        return $this->filterCollection(TypeResourceStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new TypeResourceCollection();
        foreach($queryBody as $typeResourceData) {
            if(!isset($typeResourceData['idTypeResource'])) continue;
            if(Right::canWrite($typeResourceData)) {
                $typeResource = TypeResourceStore::getById($typeResourceData['idTypeResource']);
                $typeResource->edit(Right::writeableFields($typeResourceData));
                $typeResource->save();
                $ret->ajout($typeResource);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new TypeResourceCollection();
            foreach ($queryBody as $typeResourceData) {
                if (isset($typeResourceData['idTypeResource'])) continue;
                
                if (Right::canWrite($typeResourceData)) {
                    $typeResource = new TypeResource();
                    $typeResource->edit(Right::writeableFields($typeResourceData));
                    $typeResource->save();
                    $ret->ajout($typeResource);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = TypeResourceStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = TypeResourceBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new TypeResourceCollection();
        foreach($ret as $typeResource) {
            if(Right::canDelete($typeResource)) $typeResource->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(TypeResourceBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $typeResources
     * @return array
     */
    public static function filterCollection(BaseCollection $typeResources)
    {
        $ret = [];
        foreach ($typeResources as $typeResource) {
            if(Right::canSee($typeResource)) $ret[] = Right::readableFields($typeResource);
        }
        return $ret;
    }


}