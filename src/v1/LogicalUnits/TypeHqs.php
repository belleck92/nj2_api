<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-15
 * Time: 12:29:11
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\TypeHqBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\TypeHqCollection;
use Fr\Nj2\Api\models\extended\TypeHq;
use Fr\Nj2\Api\models\store\TypeHqStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\TypeHqs as Right;

class TypeHqs extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'typeHq';

    public function getByIds($ids)
    {
        return $this->filterCollection(TypeHqStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new TypeHqCollection();
        foreach($queryBody as $typeHqData) {
            if(!isset($typeHqData['idTypeHq'])) continue;
            if(Right::canWrite($typeHqData)) {
                $typeHq = TypeHqStore::getById($typeHqData['idTypeHq']);
                $typeHq->edit(Right::writeableFields($typeHqData));
                $typeHq->save();
                $ret->ajout($typeHq);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new TypeHqCollection();
            foreach ($queryBody as $typeHqData) {
                if (isset($typeHqData['idTypeHq'])) continue;
                
                if (Right::canWrite($typeHqData)) {
                    $typeHq = new TypeHq();
                    $typeHq->edit(Right::writeableFields($typeHqData));
                    $typeHq->save();
                    $ret->ajout($typeHq);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = TypeHqStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = TypeHqBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new TypeHqCollection();
        foreach($ret as $typeHq) {
            if(Right::canDelete($typeHq)) $typeHq->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(TypeHqBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $typeHqs
     * @return array
     */
    public static function filterCollection(BaseCollection $typeHqs)
    {
        $ret = [];
        foreach ($typeHqs as $typeHq) {
            if(Right::canSee($typeHq)) $ret[] = Right::readableFields($typeHq);
        }
        return $ret;
    }


}