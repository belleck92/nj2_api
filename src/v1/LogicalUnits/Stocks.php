<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-12
 * Time: 11:44:57
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\StockBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\StockCollection;
use Fr\Nj2\Api\models\extended\Stock;
use Fr\Nj2\Api\models\store\StockStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Stocks as Right;

class Stocks extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'stock';

    public function getByIds($ids)
    {
        return $this->filterCollection(StockStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new StockCollection();
        foreach($queryBody as $stockData) {
            if(!isset($stockData['idStock'])) continue;
            if(Right::canWrite($stockData)) {
                $stock = StockStore::getById($stockData['idStock']);
                $stock->edit(Right::writeableFields($stockData));
                $stock->save();
                $ret->ajout($stock);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new StockCollection();
            foreach ($queryBody as $stockData) {
                if (isset($stockData['idStock'])) continue;
                
                if (Right::canWrite($stockData)) {
                    $stock = new Stock();
                    $stock->edit(Right::writeableFields($stockData));
                    $stock->save();
                    $ret->ajout($stock);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = StockStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = StockBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new StockCollection();
        foreach($ret as $stock) {
            if(Right::canDelete($stock)) $stock->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(StockBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $stocks
     * @return array
     */
    public static function filterCollection(BaseCollection $stocks)
    {
        $ret = [];
        foreach ($stocks as $stock) {
            if(Right::canSee($stock)) $ret[] = Right::readableFields($stock);
        }
        return $ret;
    }


}