<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\TypeHq;
use Fr\Nj2\Api\models\collection\TypeHqCollection;


class TypeHqBusiness extends BaseBusiness {

    protected static $fields = array(
        'idTypeHq'
        ,'name'
        ,'description'
        ,'fctId'
    );

    protected static $table = 'typeHq';

    /**
     * Renvoie le TypeHq demandé
     * @var int $id Id primaire du TypeHq
     * @return TypeHq
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeHqCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le TypeHq en DB
     * @param TypeHq $typeHq
     */
    public static function delete(TypeHq $typeHq) {
        $req = "DELETE FROM `typeHq` WHERE `idTypeHq` = '".$typeHq->getId()."';";
        DbHandler::delete($req);
    }
}
