<?php
/**
* Created by Manu
* Date: 2017-07-11
* Time: 17:29:12
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\extended\ProbaResourceClimate;
use Fr\Nj2\Api\models\collection\ProbaResourceClimateCollection;
use Fr\Nj2\Api\models\collection\TypeClimateCollection;
use Fr\Nj2\Api\models\extended\TypeClimate;
use Fr\Nj2\Api\models\collection\TypeResourceCollection;
use Fr\Nj2\Api\models\extended\TypeResource;


class ProbaResourceClimateBusiness extends BaseBusiness {

    protected static $fields = array(
        'idProbaResourceClimate'
        ,'idTypeResource'
        ,'idTypeClimate'
        ,'proba'
    );

    protected static $table = 'probaResourceClimate';

    /**
     * Renvoie le ProbaResourceClimate demandé
     * @var int $id Id primaire du ProbaResourceClimate
     * @return ProbaResourceClimate
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return ProbaResourceClimateCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
    /**
     * Renvoie les ProbaResourceClimates liés aux TypeClimates de la collection fournie en paramètre
     * @param TypeClimateCollection $typeClimates
     * @return ProbaResourceClimateCollection|ProbaResourceClimate[]
     */
    public static function getFromTypeClimates(TypeClimateCollection $typeClimates){
        $ids = $typeClimates->getIdsStr();
        if(!$ids) return new ProbaResourceClimateCollection();
        $req = "SELECT * FROM probaResourceClimate WHERE idTypeClimate IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'ProbaResourceClimate', 'ProbaResourceClimateCollection');
    }

    /**
     * Renvoie les ProbaResourceClimates liés à un TypeClimate
     * @param TypeClimate $typeClimate
     * @return ProbaResourceClimateCollection|ProbaResourceClimate[]
     */
    public static function getByTypeClimate(TypeClimate $typeClimate){
        $req = "SELECT * FROM probaResourceClimate WHERE idTypeClimate = '".$typeClimate->getId()."';";
        return DbHandler::collFromQuery($req, 'ProbaResourceClimate', 'ProbaResourceClimateCollection');
    }
    
    /**
     * Renvoie les ProbaResourceClimates liés aux TypeResources de la collection fournie en paramètre
     * @param TypeResourceCollection $typeResources
     * @return ProbaResourceClimateCollection|ProbaResourceClimate[]
     */
    public static function getFromTypeResources(TypeResourceCollection $typeResources){
        $ids = $typeResources->getIdsStr();
        if(!$ids) return new ProbaResourceClimateCollection();
        $req = "SELECT * FROM probaResourceClimate WHERE idTypeResource IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'ProbaResourceClimate', 'ProbaResourceClimateCollection');
    }

    /**
     * Renvoie les ProbaResourceClimates liés à un TypeResource
     * @param TypeResource $typeResource
     * @return ProbaResourceClimateCollection|ProbaResourceClimate[]
     */
    public static function getByTypeResource(TypeResource $typeResource){
        $req = "SELECT * FROM probaResourceClimate WHERE idTypeResource = '".$typeResource->getId()."';";
        return DbHandler::collFromQuery($req, 'ProbaResourceClimate', 'ProbaResourceClimateCollection');
    }
    
     /**
     * Supprime le ProbaResourceClimate en DB
     * @param ProbaResourceClimate $probaResourceClimate
     */
    public static function delete(ProbaResourceClimate $probaResourceClimate) {
        $req = "DELETE FROM `probaResourceClimate` WHERE `idProbaResourceClimate` = '".$probaResourceClimate->getId()."';";
        DbHandler::delete($req);
    }
}
