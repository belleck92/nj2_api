<?php
/**
* Created by Manu
* Date: 2017-07-15
* Time: 12:29:12
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\TypeTech;
use Fr\Nj2\Api\models\collection\TypeTechCollection;


class TypeTechBusiness extends BaseBusiness {

    protected static $fields = array(
        'idTypeTech'
        ,'idTechCategory'
        ,'idEra'
        ,'name'
        ,'description'
        ,'fctId'
        ,'idTechCategoryNeeded'
    );

    protected static $table = 'typeTech';

    /**
     * Renvoie le TypeTech demandé
     * @var int $id Id primaire du TypeTech
     * @return TypeTech
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeTechCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le TypeTech en DB
     * @param TypeTech $typeTech
     */
    public static function delete(TypeTech $typeTech) {
        $req = "DELETE FROM `typeTech` WHERE `idTypeTech` = '".$typeTech->getId()."';";
        DbHandler::delete($req);
    }
}
