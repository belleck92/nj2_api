<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\ResourceBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\ResourceCollection;
use Fr\Nj2\Api\models\extended\Resource;
use Fr\Nj2\Api\models\store\ResourceStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Resources as Right;
use Fr\Nj2\Api\v1\Extended\TypeResources;
use Fr\Nj2\Api\v1\Extended\Hexas;

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
        $segments = explode('/', $queryString);
        if(count($segments) > 1) {
            switch ($segments[1]) {
                case 'typeResources':
                    return TypeResources::filterCollection(ResourceStore::getByIds($segments[0])->getTypeResources());
            
                case 'hexas':
                    return Hexas::filterCollection(ResourceStore::getByIds($segments[0])->getHexas());
            }}
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
                if (!isset($resourceData['idTypeResource'])) continue;if (!isset($resourceData['idHexa'])) continue;
                if (Right::canWrite($resourceData)) {
                    $resource = new Resource();
                    $resource->edit(Right::writeableFields($resourceData));
                    $resource->save();
                    $ret->ajout($resource);
                }
            }
            return $this->filterCollection($ret);
        } elseif (preg_match('#^[0-9]+$#', $segments[0])) {
            if($segments[1] == "typeResources") {
                $unit = new TypeResources();
                $unit->create('', $parameters, $queryBody);
            }if($segments[1] == "hexas") {
                $unit = new Hexas();
                $unit->create('', $parameters, $queryBody);
            }
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