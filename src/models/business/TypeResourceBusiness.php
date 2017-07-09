<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 17:30:19
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\TypeResource;
use Fr\Nj2\Api\models\collection\TypeResourceCollection;


class TypeResourceBusiness extends BaseBusiness {

    protected static $fields = array(
        'idTypeResource'
        ,'name'
        ,'description'
        ,'fctId'
    );

    protected static $table = 'typeResource';

    /**
     * Renvoie le TypeResource demandé
     * @var int $id Id primaire du TypeResource
     * @return TypeResource
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeResourceCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le TypeResource en DB
     * @param TypeResource $typeResource
     */
    public static function delete(TypeResource $typeResource) {
        $req = "DELETE FROM `typeResource` WHERE `idTypeResource` = '".$typeResource->getId()."';";
        DbHandler::delete($req);
    }
}
