<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-07
 * Time: 17:53:41
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\AllianceBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\AllianceCollection;
use Fr\Nj2\Api\models\Alliance;
use Fr\Nj2\Api\models\store\AllianceStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Alliances as Right;

class Alliances extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'alliance';

    public function getByIds($ids)
    {
        return $this->filterCollection(AllianceStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new AllianceCollection();
        foreach($queryBody as $allianceData) {
            if(!isset($allianceData['idAlliance'])) continue;
            if(Right::canWrite($allianceData)) {
                $alliance = AllianceStore::getById($allianceData['idAlliance']);
                $alliance->edit(Right::writeableFields($allianceData));
                $alliance->save();
                $ret->ajout($alliance);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new AllianceCollection();
            foreach ($queryBody as $allianceData) {
                if (isset($allianceData['idAlliance'])) continue;
                
                if (Right::canWrite($allianceData)) {
                    $alliance = new Alliance();
                    $alliance->edit(Right::writeableFields($allianceData));
                    $alliance->save();
                    $ret->ajout($alliance);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = AllianceStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = AllianceBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new AllianceCollection();
        foreach($ret as $alliance) {
            if(Right::canDelete($alliance)) $alliance->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(AllianceBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $alliances
     * @return array
     */
    public static function filterCollection(BaseCollection $alliances)
    {
        $ret = [];
        foreach ($alliances as $alliance) {
            if(Right::canSee($alliance)) $ret[] = Right::readableFields($alliance);
        }
        return $ret;
    }


}