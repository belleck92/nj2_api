<?php
/**
* Created by Manu
* Date: 2017-07-12
* Time: 11:03:33
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Stock;
use Fr\Nj2\Api\models\collection\StockCollection;


class StockBusiness extends BaseBusiness {

    protected static $fields = array(
        'idStock'
        ,'idTypeResource'
        ,'idHexa'
        ,'qty'
    );

    protected static $table = 'stock';

    /**
     * Renvoie le Stock demandé
     * @var int $id Id primaire du Stock
     * @return Stock
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return StockCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le Stock en DB
     * @param Stock $stock
     */
    public static function delete(Stock $stock) {
        $req = "DELETE FROM `stock` WHERE `idStock` = '".$stock->getId()."';";
        DbHandler::delete($req);
    }
}
