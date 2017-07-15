<?php
/**
* Created by Manu
* Date: 2017-07-15
* Time: 12:29:12
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\TypeResource;
use Fr\Nj2\Api\models\collection\TypeResourceCollection;
use Fr\Nj2\Api\models\collection\ProbaResourceClimateCollection;
use Fr\Nj2\Api\models\collection\ResourceCollection;


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
     * Renvoie les TypeResources liés à une collection de ProbaResourceClimates
     * @param ProbaResourceClimateCollection $probaResourceClimates
     * @return TypeResourceCollection|TypeResource[]
     */
    public static function getFromProbaResourceClimates(ProbaResourceClimateCollection $probaResourceClimates){
        $ids = $probaResourceClimates->getIdTypeResourceStr();
        if(!$ids) return new TypeResourceCollection();
        $req = "SELECT * FROM typeResource WHERE idTypeResource IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'TypeResource', 'TypeResourceCollection');
    }

    /**
     * Renvoie les TypeResources liés à une collection de Resources
     * @param ResourceCollection $resources
     * @return TypeResourceCollection|TypeResource[]
     */
    public static function getFromResources(ResourceCollection $resources){
        $ids = $resources->getIdTypeResourceStr();
        if(!$ids) return new TypeResourceCollection();
        $req = "SELECT * FROM typeResource WHERE idTypeResource IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'TypeResource', 'TypeResourceCollection');
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
