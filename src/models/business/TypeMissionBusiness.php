<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 16:56:53
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\TypeMission;
use Fr\Nj2\Api\models\collection\TypeMissionCollection;


class TypeMissionBusiness extends BaseBusiness {

    protected static $fields = array(
        'idTypeMission'
        ,'unitOrSpy'
        ,'name'
        ,'description'
        ,'fctId'
    );

    protected static $table = 'typeMission';

    /**
     * Renvoie le TypeMission demandé
     * @var int $id Id primaire du TypeMission
     * @return TypeMission
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeMissionCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le TypeMission en DB
     * @param TypeMission $typeMission
     */
    public static function delete(TypeMission $typeMission) {
        $req = "DELETE FROM `typeMission` WHERE `idTypeMission` = '".$typeMission->getId()."';";
        DbHandler::delete($req);
    }
}
