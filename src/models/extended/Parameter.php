<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 15/07/17
 * Time: 12:29
 */

namespace Fr\Nj2\Api\models\extended;


use Exception;
use Fr\Nj2\Api\models\DbHandler;

class Parameter extends \Fr\Nj2\Api\models\Parameter
{
    const NB_TURN_GAME = 'NB_TURN_GAME';
    const MAX_PLAYERS = 'MAX_PLAYERS';
    const SLOTS_INFRA_BY_HEXA = 'SLOTS_INFRA_BY_HEXA';
    const SLOTS_BUILDING_BY_CITY = 'SLOTS_BUILDING_BY_CITY';
    const BOARDING_COST = 'BOARDING_COST';
    const STOCK_WAREHOUSE_LEVEL = 'STOCK_WAREHOUSE_LEVEL';
    const FOOD_POP_TURN = 'FOOD_POP_TURN';
    const N_PARAM_GROWTH = 'N_PARAM_GROWTH';
    const B_PARAM_GROWTH = 'B_PARAM_GROWTH';
    const MAX_POP = 'MAX_POP';
    const CAPITAL_POP = 'CAPITAL_POP';
    const TAX_GOLD_POP_TURN = 'TAX_GOLD_POP_TURN';
    const BEGINNING_TREASURY = 'BEGINNING_TREASURY';
    const BEGINNING_TAX_RATE = 'BEGINNING_TAX_RATE';
    const BUILDING_DESTRUCTION_TIME = 'BUILDING_DESTRUCTION_TIME';
    const NB_BONUS_PALACE = 'NB_BONUS_PALACE';
    const FREE_WAREHOUSE_SLOT = 'FREE_WAREHOUSE_SLOT';
    const CITY_RADIUS = 'CITY_RADIUS';
    const CITY_VISIBILITY_RADIUS = 'CITY_VISIBILITY_RADIUS';
    const EXPERT_NB_UNITS = 'EXPERT_NB_UNITS';
    const EXPERT_NB_BUILDINGS = 'EXPERT_NB_BUILDINGS';
    const EXPERT_NB_TURNS = 'EXPERT_NB_TURNS';
    const CONQUEST_MALUS = 'CONQUEST_MALUS';
    const CONQUEST_MALUS_DECREASE = 'CONQUEST_MALUS_DECREASE';
    const PROBA_FORD = 'PROBA_FORD';

    /**
     * @var array
     */
    private static $storage;

    /**
     * @param string $fctId
     * @return Parameter
     * @throws Exception
     */
    public static function getByFctId($fctId)
    {
        if(is_null(self::$storage)) self::initTypes();
        if(!self::$storage[$fctId]) throw new Exception($fctId." type doesn't exists");
        return self::$storage[$fctId];
    }

    /**
     * @param string $fctId
     * @return string
     */
    public static function val($fctId)
    {
        return self::getByFctId($fctId)->getValue();
    }

    /**
     * Gets the types in database
     */
    public static function initTypes()
    {
        self::$storage = [];
        $req = "SELECT * FROM parameter;";
        $res = DbHandler::query($req);
        while($line = mysqli_fetch_assoc($res)) {
            $parameter = new Parameter();
            $parameter->edit($line);
            self::$storage[$parameter->getFctId()] = $parameter;
        }
    }

}