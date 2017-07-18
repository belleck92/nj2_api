<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\store;

use Exception;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\Bean;
use Fr\Nj2\Api\models\business\BaseBusiness;
use Fr\Nj2\Api\models\business\AllianceBusiness;
use Fr\Nj2\Api\models\business\BonusBusiness;
use Fr\Nj2\Api\models\business\BuildingBusiness;
use Fr\Nj2\Api\models\business\CaravanBusiness;
use Fr\Nj2\Api\models\business\ExpertBusiness;
use Fr\Nj2\Api\models\business\GameBusiness;
use Fr\Nj2\Api\models\business\HexaBusiness;
use Fr\Nj2\Api\models\business\HqBusiness;
use Fr\Nj2\Api\models\business\PalaceBonusBusiness;
use Fr\Nj2\Api\models\business\ParameterBusiness;
use Fr\Nj2\Api\models\business\PlayerBusiness;
use Fr\Nj2\Api\models\business\ProbaResourceClimateBusiness;
use Fr\Nj2\Api\models\business\ResourceBusiness;
use Fr\Nj2\Api\models\business\RiverBusiness;
use Fr\Nj2\Api\models\business\SaleBusiness;
use Fr\Nj2\Api\models\business\SpyBusiness;
use Fr\Nj2\Api\models\business\StockBusiness;
use Fr\Nj2\Api\models\business\TechBusiness;
use Fr\Nj2\Api\models\business\TrajectoryBusiness;
use Fr\Nj2\Api\models\business\TrajectoryHexaBusiness;
use Fr\Nj2\Api\models\business\TreatyBusiness;
use Fr\Nj2\Api\models\business\TypeBonusBusiness;
use Fr\Nj2\Api\models\business\TypeBuildingBusiness;
use Fr\Nj2\Api\models\business\TypeClimateBusiness;
use Fr\Nj2\Api\models\business\TypeHqBusiness;
use Fr\Nj2\Api\models\business\TypeMissionBusiness;
use Fr\Nj2\Api\models\business\TypeResourceBusiness;
use Fr\Nj2\Api\models\business\TypeResourceBonusBusiness;
use Fr\Nj2\Api\models\business\TypeTechBusiness;
use Fr\Nj2\Api\models\business\TypeTechBonusBusiness;
use Fr\Nj2\Api\models\business\TypeTreatyBusiness;
use Fr\Nj2\Api\models\business\TypeUnitBusiness;
use Fr\Nj2\Api\models\business\TypeUnitMissionBusiness;
use Fr\Nj2\Api\models\business\UnitBusiness;
use Fr\Nj2\Api\models\business\UserBusiness;

abstract class BaseStore {

    private static $stock = array();
    private static $table;

    /**
     * @param int $id Id de l'objet à renvoyer
     * @return Bean
     */
    public static function getById($id){
        if(self::exists($id)) return self::$stock[static::$table][$id];
        else {
            $business =  'Fr\\Nj2\\Api\\models\\business\\'.BaseBusiness::underscoreToCamelCase(static::$table).'Business';
            self::$stock[static::$table][$id] = $business::getById($id);
        }
        return self::$stock[static::$table][$id];
    }

    /**
     * @param string $ids Ids des objets à renvoyer, séparés par des virgules
     * @return Bean
     * @throws Exception
     */
    public static function getByIds($ids){
        $class = 'Fr\\Nj2\\Api\\models\\collection\\'.BaseBusiness::underscoreToCamelCase(static::$table).'Collection';
        $business = 'Fr\\Nj2\\Api\\models\\business\\' . BaseBusiness::underscoreToCamelCase(static::$table) . 'Business';
        $ret = new $class; /** @var BaseCollection $ret */
        if(!preg_match('"^([0-9],?)+$"', $ids)) throw new Exception("Bad format for ids");
        $ids = explode(',', $ids);
        $idsToQuery = '';
        foreach($ids as $id) {
            if (self::exists($id)) $ret->append(self::$stock[static::$table][$id]);
            else {
                if(!empty($idsToQuery)) $idsToQuery .= ',';
                $idsToQuery .= $id;
            }
        }
        if(!empty($idsToQuery)) {
            foreach ($business::getByIds($idsToQuery) as $bean) {
                static::store($bean);
                $ret->append($bean);
            }
        }
        return $ret;
    }

    /**
     * Vérifie si un Id d'objet est déjà storé
     * @param int $id
     * @return boolean
     */
    public static function exists($id){
        return isset(self::$stock[static::$table][$id]);
    }

    /**
     * Store l'objet
     * @param Bean $obj
     */
    public static function store(Bean $obj){
        self::$stock[static::$table][$obj->getId()] = $obj;
    }
}