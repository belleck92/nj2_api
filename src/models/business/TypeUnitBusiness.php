<?php
/**
* Created by Manu
* Date: 2017-07-14
* Time: 11:44:36
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\TypeUnit;
use Fr\Nj2\Api\models\collection\TypeUnitCollection;


class TypeUnitBusiness extends BaseBusiness {

    protected static $fields = array(
        'idTypeMission'
        ,'idTypeHq'
        ,'name'
        ,'description'
        ,'fctId'
        ,'assault'
        ,'resistance'
        ,'mvt'
        ,'idTypeBuilding'
        ,'zIndex'
        ,'mecanized'
        ,'motorized'
        ,'visionRange'
        ,'price'
        ,'buildingTime'
    );

    protected static $table = 'typeUnit';

    /**
     * Renvoie le TypeUnit demandé
     * @var int $id Id primaire du TypeUnit
     * @return TypeUnit
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeUnitCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le TypeUnit en DB
     * @param TypeUnit $typeUnit
     */
    public static function delete(TypeUnit $typeUnit) {
        $req = "DELETE FROM `typeUnit` WHERE `idTypeMission` = '".$typeUnit->getId()."';";
        DbHandler::delete($req);
    }
}
