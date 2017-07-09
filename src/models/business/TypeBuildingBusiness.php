<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 15:09:50
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\TypeBuilding;
use Fr\Nj2\Api\models\collection\TypeBuildingCollection;


class TypeBuildingBusiness extends BaseBusiness {

    protected static $fields = array(
        'idTypeBuilding'
        ,'name'
        ,'description'
        ,'fctId'
        ,'price'
        ,'buildingTime'
        ,'maxLevel'
        ,'priceCoef'
        ,'maintenancePriceRatio'
        ,'needsPopulation'
        ,'investmentCapacity'
        ,'priorityLevel'
    );

    protected static $table = 'typeBuilding';

    /**
     * Renvoie le TypeBuilding demandé
     * @var int $id Id primaire du TypeBuilding
     * @return TypeBuilding
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeBuildingCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le TypeBuilding en DB
     * @param TypeBuilding $typeBuilding
     */
    public static function delete(TypeBuilding $typeBuilding) {
        $req = "DELETE FROM `typeBuilding` WHERE `idTypeBuilding` = '".$typeBuilding->getId()."';";
        DbHandler::delete($req);
    }
}
