<?php
/**
* Created by Manu
* Date: 2017-07-15
* Time: 12:29:12
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Parameter;
use Fr\Nj2\Api\models\collection\ParameterCollection;


class ParameterBusiness extends BaseBusiness {

    protected static $fields = array(
        'idParameter'
        ,'value'
        ,'description'
        ,'fctId'
    );

    protected static $table = 'parameter';

    /**
     * Renvoie le Parameter demandé
     * @var int $id Id primaire du Parameter
     * @return Parameter
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return ParameterCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le Parameter en DB
     * @param Parameter $parameter
     */
    public static function delete(Parameter $parameter) {
        $req = "DELETE FROM `parameter` WHERE `idParameter` = '".$parameter->getId()."';";
        DbHandler::delete($req);
    }
}
