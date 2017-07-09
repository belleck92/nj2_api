<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 16:56:52
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\TrajectoryHexa;
use Fr\Nj2\Api\models\collection\TrajectoryHexaCollection;


class TrajectoryHexaBusiness extends BaseBusiness {

    protected static $fields = array(
        'idTrajectoryHexa'
        ,'idTrajectory'
        ,'idHexa'
        ,'rank'
    );

    protected static $table = 'trajectoryHexa';

    /**
     * Renvoie le TrajectoryHexa demandé
     * @var int $id Id primaire du TrajectoryHexa
     * @return TrajectoryHexa
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TrajectoryHexaCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le TrajectoryHexa en DB
     * @param TrajectoryHexa $trajectoryHexa
     */
    public static function delete(TrajectoryHexa $trajectoryHexa) {
        $req = "DELETE FROM `trajectoryHexa` WHERE `idTrajectoryHexa` = '".$trajectoryHexa->getId()."';";
        DbHandler::delete($req);
    }
}
