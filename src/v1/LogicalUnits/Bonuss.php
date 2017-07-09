<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-09
 * Time: 16:55:27
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\BonusBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\BonusCollection;
use Fr\Nj2\Api\models\extended\Bonus;
use Fr\Nj2\Api\models\store\BonusStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Bonuss as Right;

class Bonuss extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'bonus';

    public function getByIds($ids)
    {
        return $this->filterCollection(BonusStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new BonusCollection();
        foreach($queryBody as $bonusData) {
            if(!isset($bonusData['idBonus'])) continue;
            if(Right::canWrite($bonusData)) {
                $bonus = BonusStore::getById($bonusData['idBonus']);
                $bonus->edit(Right::writeableFields($bonusData));
                $bonus->save();
                $ret->ajout($bonus);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new BonusCollection();
            foreach ($queryBody as $bonusData) {
                if (isset($bonusData['idBonus'])) continue;
                
                if (Right::canWrite($bonusData)) {
                    $bonus = new Bonus();
                    $bonus->edit(Right::writeableFields($bonusData));
                    $bonus->save();
                    $ret->ajout($bonus);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = BonusStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = BonusBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new BonusCollection();
        foreach($ret as $bonus) {
            if(Right::canDelete($bonus)) $bonus->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(BonusBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $bonuss
     * @return array
     */
    public static function filterCollection(BaseCollection $bonuss)
    {
        $ret = [];
        foreach ($bonuss as $bonus) {
            if(Right::canSee($bonus)) $ret[] = Right::readableFields($bonus);
        }
        return $ret;
    }


}