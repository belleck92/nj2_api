<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\TypeTechBonusBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\TypeTechBonusCollection;
use Fr\Nj2\Api\models\extended\TypeTechBonus;
use Fr\Nj2\Api\models\store\TypeTechBonusStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\TypeTechBonuss as Right;

class TypeTechBonuss extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'typeTechBonus';

    public function getByIds($ids)
    {
        return $this->filterCollection(TypeTechBonusStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new TypeTechBonusCollection();
        foreach($queryBody as $typeTechBonusData) {
            if(!isset($typeTechBonusData['idTypeTechBonus'])) continue;
            if(Right::canWrite($typeTechBonusData)) {
                $typeTechBonus = TypeTechBonusStore::getById($typeTechBonusData['idTypeTechBonus']);
                $typeTechBonus->edit(Right::writeableFields($typeTechBonusData));
                $typeTechBonus->save();
                $ret->ajout($typeTechBonus);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new TypeTechBonusCollection();
            foreach ($queryBody as $typeTechBonusData) {
                if (isset($typeTechBonusData['idTypeTechBonus'])) continue;
                if (Right::canWrite($typeTechBonusData)) {
                    $typeTechBonus = new TypeTechBonus();
                    $typeTechBonus->edit(Right::writeableFields($typeTechBonusData));
                    $typeTechBonus->save();
                    $ret->ajout($typeTechBonus);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = TypeTechBonusStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = TypeTechBonusBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new TypeTechBonusCollection();
        foreach($ret as $typeTechBonus) {
            if(Right::canDelete($typeTechBonus)) $typeTechBonus->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(TypeTechBonusBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $typeTechBonuss
     * @return array
     */
    public static function filterCollection(BaseCollection $typeTechBonuss)
    {
        $ret = [];
        foreach ($typeTechBonuss as $typeTechBonus) {
            if(Right::canSee($typeTechBonus)) $ret[] = Right::readableFields($typeTechBonus);
        }
        return $ret;
    }


}