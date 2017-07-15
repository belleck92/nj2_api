<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-15
 * Time: 12:29:11
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\SaleBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\SaleCollection;
use Fr\Nj2\Api\models\extended\Sale;
use Fr\Nj2\Api\models\store\SaleStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Sales as Right;

class Sales extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'sale';

    public function getByIds($ids)
    {
        return $this->filterCollection(SaleStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new SaleCollection();
        foreach($queryBody as $saleData) {
            if(!isset($saleData['idSale'])) continue;
            if(Right::canWrite($saleData)) {
                $sale = SaleStore::getById($saleData['idSale']);
                $sale->edit(Right::writeableFields($saleData));
                $sale->save();
                $ret->ajout($sale);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new SaleCollection();
            foreach ($queryBody as $saleData) {
                if (isset($saleData['idSale'])) continue;
                
                if (Right::canWrite($saleData)) {
                    $sale = new Sale();
                    $sale->edit(Right::writeableFields($saleData));
                    $sale->save();
                    $ret->ajout($sale);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = SaleStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = SaleBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new SaleCollection();
        foreach($ret as $sale) {
            if(Right::canDelete($sale)) $sale->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(SaleBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $sales
     * @return array
     */
    public static function filterCollection(BaseCollection $sales)
    {
        $ret = [];
        foreach ($sales as $sale) {
            if(Right::canSee($sale)) $ret[] = Right::readableFields($sale);
        }
        return $ret;
    }


}