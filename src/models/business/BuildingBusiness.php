<?php
/**
* Created by Manu
* Date: 2017-07-10
* Time: 17:24:40
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Building;
use Fr\Nj2\Api\models\collection\BuildingCollection;


class BuildingBusiness extends BaseBusiness {

    protected static $fields = array(
        'idBuilding'
        ,'idHexa'
        ,'idTypeBuilding'
        ,'actualLevel'
        ,'buildingTurnsLeft'
        ,'populationWorking'
    );

    protected static $table = 'building';

    /**
     * Renvoie le Building demandé
     * @var int $id Id primaire du Building
     * @return Building
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return BuildingCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le Building en DB
     * @param Building $building
     */
    public static function delete(Building $building) {
        $req = "DELETE FROM `building` WHERE `idBuilding` = '".$building->getId()."';";
        DbHandler::delete($req);
    }
}
