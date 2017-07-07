<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-07
 * Time: 17:53:41
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\TypeTechBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\TypeTechCollection;
use Fr\Nj2\Api\models\TypeTech;
use Fr\Nj2\Api\models\store\TypeTechStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\TypeTechs as Right;

class TypeTechs extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'typeTech';

    public function getByIds($ids)
    {
        return $this->filterCollection(TypeTechStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new TypeTechCollection();
        foreach($queryBody as $typeTechData) {
            if(!isset($typeTechData['idTypeTech'])) continue;
            if(Right::canWrite($typeTechData)) {
                $typeTech = TypeTechStore::getById($typeTechData['idTypeTech']);
                $typeTech->edit(Right::writeableFields($typeTechData));
                $typeTech->save();
                $ret->ajout($typeTech);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new TypeTechCollection();
            foreach ($queryBody as $typeTechData) {
                if (isset($typeTechData['idTypeTech'])) continue;
                
                if (Right::canWrite($typeTechData)) {
                    $typeTech = new TypeTech();
                    $typeTech->edit(Right::writeableFields($typeTechData));
                    $typeTech->save();
                    $ret->ajout($typeTech);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = TypeTechStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = TypeTechBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new TypeTechCollection();
        foreach($ret as $typeTech) {
            if(Right::canDelete($typeTech)) $typeTech->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(TypeTechBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $typeTechs
     * @return array
     */
    public static function filterCollection(BaseCollection $typeTechs)
    {
        $ret = [];
        foreach ($typeTechs as $typeTech) {
            if(Right::canSee($typeTech)) $ret[] = Right::readableFields($typeTech);
        }
        return $ret;
    }


}