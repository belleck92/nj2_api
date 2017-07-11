<?php
/**
* Created by Manu
* Date: 2017-07-10
* Time: 17:24:40
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\Expert;
use Fr\Nj2\Api\models\collection\ExpertCollection;


class ExpertBusiness extends BaseBusiness {

    protected static $fields = array(
        'idExpert'
        ,'idPlayer'
        ,'idBonus'
        ,'idHexa'
        ,'itemsLeft'
        ,'turnsLeft'
    );

    protected static $table = 'expert';

    /**
     * Renvoie le Expert demandé
     * @var int $id Id primaire du Expert
     * @return Expert
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return ExpertCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
     /**
     * Supprime le Expert en DB
     * @param Expert $expert
     */
    public static function delete(Expert $expert) {
        $req = "DELETE FROM `expert` WHERE `idExpert` = '".$expert->getId()."';";
        DbHandler::delete($req);
    }
}
