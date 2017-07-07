<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-07
 * Time: 17:53:41
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\ResourceBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\ResourceCollection;
use Fr\Nj2\Api\models\Resource;
use Fr\Nj2\Api\models\store\ResourceStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Resources as Right;

class Resources extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'resource';

    public function getByIds($ids)
    {
        return $this->filterCollection(ResourceStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new ResourceCollection();
        foreach($queryBody as $resourceData) {
            if(!isset($resourceData['idResource'])) continue;
            if(Right::canWrite($resourceData)) {
                $resource = ResourceStore::getById($resourceData['idResource']);
                $resource->edit(Right::writeableFields($resourceData));
                $resource->save();
                $ret->ajout($resource);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new ResourceCollection();
            foreach ($queryBody as $resourceData) {
                if (isset($resourceData['idResource'])) continue;
                
                if (Right::canWrite($resourceData)) {
                    $resource = new Resource();
                    $resource->edit(Right::writeableFields($resourceData));
                    $resource->save();
                    $ret->ajout($resource);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = ResourceStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = ResourceBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new ResourceCollection();
        foreach($ret as $resource) {
            if(Right::canDelete($resource)) $resource->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(ResourceBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $resources
     * @return array
     */
    public static function filterCollection(BaseCollection $resources)
    {
        $ret = [];
        foreach ($resources as $resource) {
            if(Right::canSee($resource)) $ret[] = Right::readableFields($resource);
        }
        return $ret;
    }


}