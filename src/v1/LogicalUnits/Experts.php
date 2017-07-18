<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\ExpertBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\ExpertCollection;
use Fr\Nj2\Api\models\extended\Expert;
use Fr\Nj2\Api\models\store\ExpertStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Experts as Right;

class Experts extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'expert';

    public function getByIds($ids)
    {
        return $this->filterCollection(ExpertStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new ExpertCollection();
        foreach($queryBody as $expertData) {
            if(!isset($expertData['idExpert'])) continue;
            if(Right::canWrite($expertData)) {
                $expert = ExpertStore::getById($expertData['idExpert']);
                $expert->edit(Right::writeableFields($expertData));
                $expert->save();
                $ret->ajout($expert);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new ExpertCollection();
            foreach ($queryBody as $expertData) {
                if (isset($expertData['idExpert'])) continue;
                if (Right::canWrite($expertData)) {
                    $expert = new Expert();
                    $expert->edit(Right::writeableFields($expertData));
                    $expert->save();
                    $ret->ajout($expert);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = ExpertStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = ExpertBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new ExpertCollection();
        foreach($ret as $expert) {
            if(Right::canDelete($expert)) $expert->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(ExpertBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $experts
     * @return array
     */
    public static function filterCollection(BaseCollection $experts)
    {
        $ret = [];
        foreach ($experts as $expert) {
            if(Right::canSee($expert)) $ret[] = Right::readableFields($expert);
        }
        return $ret;
    }


}