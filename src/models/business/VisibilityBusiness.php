<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Visibility;
use Fr\Nj2\Api\models\collection\VisibilityCollection;


class VisibilityBusiness extends BaseBusiness {

    protected static $fields = array(
        'idVisibility'
        ,'idPlayer'
        ,'idHexa'
        ,'level'
    );

    protected static $table = 'visibility';

    /**
     * Renvoie le Visibility demandé
     * @var int $id Id primaire du Visibility
     * @return Visibility
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return VisibilityCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le Visibility en DB
     * @param Visibility $visibility
     */
    public static function delete(Visibility $visibility) {
        $req = "DELETE FROM `visibility` WHERE `idVisibility` = '".$visibility->getId()."';";
        DbHandler::delete($req);
    }
}
