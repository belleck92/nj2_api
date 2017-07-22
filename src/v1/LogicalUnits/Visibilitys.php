<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\VisibilityBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\VisibilityCollection;
use Fr\Nj2\Api\models\extended\Visibility;
use Fr\Nj2\Api\models\store\VisibilityStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Visibilitys as Right;

class Visibilitys extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'visibility';

    public function getByIds($ids)
    {
        return $this->filterCollection(VisibilityStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new VisibilityCollection();
        foreach($queryBody as $visibilityData) {
            if(!isset($visibilityData['idVisibility'])) continue;
            if(Right::canWrite($visibilityData)) {
                $visibility = VisibilityStore::getById($visibilityData['idVisibility']);
                $visibility->edit(Right::writeableFields($visibilityData));
                $visibility->save();
                $ret->ajout($visibility);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new VisibilityCollection();
            foreach ($queryBody as $visibilityData) {
                if (isset($visibilityData['idVisibility'])) continue;
                if (Right::canWrite($visibilityData)) {
                    $visibility = new Visibility();
                    $visibility->edit(Right::writeableFields($visibilityData));
                    $visibility->save();
                    $ret->ajout($visibility);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = VisibilityStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = VisibilityBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new VisibilityCollection();
        foreach($ret as $visibility) {
            if(Right::canDelete($visibility)) $visibility->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(VisibilityBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $visibilitys
     * @return array
     */
    public static function filterCollection(BaseCollection $visibilitys)
    {
        $ret = [];
        foreach ($visibilitys as $visibility) {
            if(Right::canSee($visibility)) $ret[] = Right::readableFields($visibility);
        }
        return $ret;
    }


}