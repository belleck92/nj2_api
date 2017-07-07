<?php
/**
* Created by Manu
* Date: 2017-07-07
* Time: 17:53:40
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\Sale;
use Fr\Nj2\Api\models\collection\SaleCollection;


class SaleBusiness extends BaseBusiness {

    protected static $fields = array(
        'idSale'
        ,'idHexa'
        ,'price'
        ,'idTypeResource'
        ,'qty'
        ,'idExpert'
        ,'idTypeTech'
        ,'citySale'
        ,'idUnit'
        ,'idSpy'
    );

    protected static $table = 'sale';

    /**
     * Renvoie le Sale demandé
     * @var int $id Id primaire du Sale
     * @return Sale
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return SaleCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le Sale en DB
     * @param Sale $sale
     */
    public static function delete(Sale $sale) {
        $req = "DELETE FROM `sale` WHERE `idSale` = '".$sale->getId()."';";
        DbHandler::delete($req);
    }
}
