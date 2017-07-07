<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-07
 * Time: 17:53:41
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\TechBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\TechCollection;
use Fr\Nj2\Api\models\Tech;
use Fr\Nj2\Api\models\store\TechStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Techs as Right;

class Techs extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'tech';

    public function getByIds($ids)
    {
        return $this->filterCollection(TechStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new TechCollection();
        foreach($queryBody as $techData) {
            if(!isset($techData['idTech'])) continue;
            if(Right::canWrite($techData)) {
                $tech = TechStore::getById($techData['idTech']);
                $tech->edit(Right::writeableFields($techData));
                $tech->save();
                $ret->ajout($tech);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new TechCollection();
            foreach ($queryBody as $techData) {
                if (isset($techData['idTech'])) continue;
                
                if (Right::canWrite($techData)) {
                    $tech = new Tech();
                    $tech->edit(Right::writeableFields($techData));
                    $tech->save();
                    $ret->ajout($tech);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = TechStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = TechBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new TechCollection();
        foreach($ret as $tech) {
            if(Right::canDelete($tech)) $tech->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(TechBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $techs
     * @return array
     */
    public static function filterCollection(BaseCollection $techs)
    {
        $ret = [];
        foreach ($techs as $tech) {
            if(Right::canSee($tech)) $ret[] = Right::readableFields($tech);
        }
        return $ret;
    }


}