<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Resource;
use Fr\Nj2\Api\models\collection\ResourceCollection;
use Fr\Nj2\Api\models\collection\TypeResourceCollection;
use Fr\Nj2\Api\models\extended\TypeResource;
use Fr\Nj2\Api\models\collection\HexaCollection;
use Fr\Nj2\Api\models\extended\Hexa;


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
     * Renvoie les Resources liés aux TypeResources de la collection fournie en paramètre
     * @param TypeResourceCollection $typeResources
     * @return ResourceCollection|Resource[]
     */
    public static function getFromTypeResources(TypeResourceCollection $typeResources){
        $ids = $typeResources->getIdsStr();
        if(!$ids) return new ResourceCollection();
        $req = "SELECT * FROM resource WHERE idTypeResource IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'Resource', 'ResourceCollection');
    }

    /**
     * Renvoie les Resources liés à un TypeResource
     * @param TypeResource $typeResource
     * @return ResourceCollection|Resource[]
     */
    public static function getByTypeResource(TypeResource $typeResource){
        $req = "SELECT * FROM resource WHERE idTypeResource = '".$typeResource->getId()."';";
        return DbHandler::collFromQuery($req, 'Resource', 'ResourceCollection');
    }
    
    /**
     * Renvoie les Resources liés aux Hexas de la collection fournie en paramètre
     * @param HexaCollection $hexas
     * @return ResourceCollection|Resource[]
     */
    public static function getFromHexas(HexaCollection $hexas){
        $ids = $hexas->getIdsStr();
        if(!$ids) return new ResourceCollection();
        $req = "SELECT * FROM resource WHERE idHexa IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'Resource', 'ResourceCollection');
    }

    /**
     * Renvoie les Resources liés à un Hexa
     * @param Hexa $hexa
     * @return ResourceCollection|Resource[]
     */
    public static function getByHexa(Hexa $hexa){
        $req = "SELECT * FROM resource WHERE idHexa = '".$hexa->getId()."';";
        return DbHandler::collFromQuery($req, 'Resource', 'ResourceCollection');
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
