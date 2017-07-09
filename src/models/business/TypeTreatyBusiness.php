<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 16:56:53
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\TypeTreaty;
use Fr\Nj2\Api\models\collection\TypeTreatyCollection;


class TypeTreatyBusiness extends BaseBusiness {

    protected static $fields = array(
        'idTypeTreaty'
        ,'name'
        ,'description'
        ,'fctId'
    );

    protected static $table = 'typeTreaty';

    /**
     * Renvoie le TypeTreaty demandé
     * @var int $id Id primaire du TypeTreaty
     * @return TypeTreaty
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return TypeTreatyCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le TypeTreaty en DB
     * @param TypeTreaty $typeTreaty
     */
    public static function delete(TypeTreaty $typeTreaty) {
        $req = "DELETE FROM `typeTreaty` WHERE `idTypeTreaty` = '".$typeTreaty->getId()."';";
        DbHandler::delete($req);
    }
}
