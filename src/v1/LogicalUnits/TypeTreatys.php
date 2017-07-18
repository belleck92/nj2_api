<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\TypeTreatyBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\TypeTreatyCollection;
use Fr\Nj2\Api\models\extended\TypeTreaty;
use Fr\Nj2\Api\models\store\TypeTreatyStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\TypeTreatys as Right;

class TypeTreatys extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'typeTreaty';

    public function getByIds($ids)
    {
        return $this->filterCollection(TypeTreatyStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new TypeTreatyCollection();
        foreach($queryBody as $typeTreatyData) {
            if(!isset($typeTreatyData['idTypeTreaty'])) continue;
            if(Right::canWrite($typeTreatyData)) {
                $typeTreaty = TypeTreatyStore::getById($typeTreatyData['idTypeTreaty']);
                $typeTreaty->edit(Right::writeableFields($typeTreatyData));
                $typeTreaty->save();
                $ret->ajout($typeTreaty);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new TypeTreatyCollection();
            foreach ($queryBody as $typeTreatyData) {
                if (isset($typeTreatyData['idTypeTreaty'])) continue;
                
                if (Right::canWrite($typeTreatyData)) {
                    $typeTreaty = new TypeTreaty();
                    $typeTreaty->edit(Right::writeableFields($typeTreatyData));
                    $typeTreaty->save();
                    $ret->ajout($typeTreaty);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = TypeTreatyStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = TypeTreatyBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new TypeTreatyCollection();
        foreach($ret as $typeTreaty) {
            if(Right::canDelete($typeTreaty)) $typeTreaty->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(TypeTreatyBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $typeTreatys
     * @return array
     */
    public static function filterCollection(BaseCollection $typeTreatys)
    {
        $ret = [];
        foreach ($typeTreatys as $typeTreaty) {
            if(Right::canSee($typeTreaty)) $ret[] = Right::readableFields($typeTreaty);
        }
        return $ret;
    }


}