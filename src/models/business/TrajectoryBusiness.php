<?php
/**
* Created by Manu
* Date: 2017-07-12
* Time: 12:12:19
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Trajectory;
use Fr\Nj2\Api\models\collection\TrajectoryCollection;


class TrajectoryBusiness extends BaseBusiness {

    protected static $fields = array(
        'idTrajectory'
        ,'idHq'
        ,'idSpy'
        ,'idCaravan'
        ,'idExpert'
    );

    protected static $table = 'trajectory';

    /**
     * Renvoie le Trajectory demandé
     * @var int $id Id primaire du Trajectory
     * @return Trajectory
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TrajectoryCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le Trajectory en DB
     * @param Trajectory $trajectory
     */
    public static function delete(Trajectory $trajectory) {
        $req = "DELETE FROM `trajectory` WHERE `idTrajectory` = '".$trajectory->getId()."';";
        DbHandler::delete($req);
    }
}
