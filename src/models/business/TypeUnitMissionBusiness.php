<?php
/**
* Created by Manu
* Date: 2017-07-14
* Time: 11:44:36
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\TypeUnitMission;
use Fr\Nj2\Api\models\collection\TypeUnitMissionCollection;


class TypeUnitMissionBusiness extends BaseBusiness {

    protected static $fields = array(
        'idTypeUnitMission'
        ,'idTypeUnit'
        ,'idTypeMission'
    );

    protected static $table = 'typeUnitMission';

    /**
     * Renvoie le TypeUnitMission demandé
     * @var int $id Id primaire du TypeUnitMission
     * @return TypeUnitMission
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeUnitMissionCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le TypeUnitMission en DB
     * @param TypeUnitMission $typeUnitMission
     */
    public static function delete(TypeUnitMission $typeUnitMission) {
        $req = "DELETE FROM `typeUnitMission` WHERE `idTypeUnitMission` = '".$typeUnitMission->getId()."';";
        DbHandler::delete($req);
    }
}
