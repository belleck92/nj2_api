<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-15
 * Time: 12:29:11
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\PalaceBonusBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\PalaceBonusCollection;
use Fr\Nj2\Api\models\extended\PalaceBonus;
use Fr\Nj2\Api\models\store\PalaceBonusStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\PalaceBonuss as Right;

class PalaceBonuss extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'palaceBonus';

    public function getByIds($ids)
    {
        return $this->filterCollection(PalaceBonusStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new PalaceBonusCollection();
        foreach($queryBody as $palaceBonusData) {
            if(!isset($palaceBonusData['idPalaceBonus'])) continue;
            if(Right::canWrite($palaceBonusData)) {
                $palaceBonus = PalaceBonusStore::getById($palaceBonusData['idPalaceBonus']);
                $palaceBonus->edit(Right::writeableFields($palaceBonusData));
                $palaceBonus->save();
                $ret->ajout($palaceBonus);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new PalaceBonusCollection();
            foreach ($queryBody as $palaceBonusData) {
                if (isset($palaceBonusData['idPalaceBonus'])) continue;
                
                if (Right::canWrite($palaceBonusData)) {
                    $palaceBonus = new PalaceBonus();
                    $palaceBonus->edit(Right::writeableFields($palaceBonusData));
                    $palaceBonus->save();
                    $ret->ajout($palaceBonus);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = PalaceBonusStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = PalaceBonusBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new PalaceBonusCollection();
        foreach($ret as $palaceBonus) {
            if(Right::canDelete($palaceBonus)) $palaceBonus->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(PalaceBonusBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $palaceBonuss
     * @return array
     */
    public static function filterCollection(BaseCollection $palaceBonuss)
    {
        $ret = [];
        foreach ($palaceBonuss as $palaceBonus) {
            if(Right::canSee($palaceBonus)) $ret[] = Right::readableFields($palaceBonus);
        }
        return $ret;
    }


}