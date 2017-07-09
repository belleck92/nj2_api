<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-09
 * Time: 16:55:27
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\TreatyBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\TreatyCollection;
use Fr\Nj2\Api\models\extended\Treaty;
use Fr\Nj2\Api\models\store\TreatyStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Treatys as Right;

class Treatys extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'treaty';

    public function getByIds($ids)
    {
        return $this->filterCollection(TreatyStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new TreatyCollection();
        foreach($queryBody as $treatyData) {
            if(!isset($treatyData['idTreaty'])) continue;
            if(Right::canWrite($treatyData)) {
                $treaty = TreatyStore::getById($treatyData['idTreaty']);
                $treaty->edit(Right::writeableFields($treatyData));
                $treaty->save();
                $ret->ajout($treaty);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new TreatyCollection();
            foreach ($queryBody as $treatyData) {
                if (isset($treatyData['idTreaty'])) continue;
                
                if (Right::canWrite($treatyData)) {
                    $treaty = new Treaty();
                    $treaty->edit(Right::writeableFields($treatyData));
                    $treaty->save();
                    $ret->ajout($treaty);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = TreatyStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = TreatyBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new TreatyCollection();
        foreach($ret as $treaty) {
            if(Right::canDelete($treaty)) $treaty->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(TreatyBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $treatys
     * @return array
     */
    public static function filterCollection(BaseCollection $treatys)
    {
        $ret = [];
        foreach ($treatys as $treaty) {
            if(Right::canSee($treaty)) $ret[] = Right::readableFields($treaty);
        }
        return $ret;
    }


}