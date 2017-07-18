<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\TypeTechBonus;
use Fr\Nj2\Api\models\collection\TypeTechBonusCollection;


class TypeTechBonusBusiness extends BaseBusiness {

    protected static $fields = array(
        'idTechBonus'
        ,'idTypeTech'
        ,'idBonus'
    );

    protected static $table = 'typeTechBonus';

    /**
     * Renvoie le TypeTechBonus demandé
     * @var int $id Id primaire du TypeTechBonus
     * @return TypeTechBonus
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeTechBonusCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le TypeTechBonus en DB
     * @param TypeTechBonus $typeTechBonus
     */
    public static function delete(TypeTechBonus $typeTechBonus) {
        $req = "DELETE FROM `typeTechBonus` WHERE `idTechBonus` = '".$typeTechBonus->getId()."';";
        DbHandler::delete($req);
    }
}
