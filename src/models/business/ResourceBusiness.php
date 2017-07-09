<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 15:09:50
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\Resource;
use Fr\Nj2\Api\models\collection\ResourceCollection;


class ResourceBusiness extends BaseBusiness {

    protected static $fields = array(
        'idResource'
        ,'idHexa'
        ,'idTypeResource'
        ,'fctId'
    );

    protected static $table = 'resource';

    /**
     * Renvoie le Resource demandé
     * @var int $id Id primaire du Resource
     * @return Resource
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return ResourceCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le Resource en DB
     * @param Resource $resource
     */
    public static function delete(Resource $resource) {
        $req = "DELETE FROM `resource` WHERE `idResource` = '".$resource->getId()."';";
        DbHandler::delete($req);
    }
}
