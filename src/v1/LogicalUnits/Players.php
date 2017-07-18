<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\PlayerBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\PlayerCollection;
use Fr\Nj2\Api\models\extended\Player;
use Fr\Nj2\Api\models\store\PlayerStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Players as Right;

class Players extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'player';

    public function getByIds($ids)
    {
        return $this->filterCollection(PlayerStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new PlayerCollection();
        foreach($queryBody as $playerData) {
            if(!isset($playerData['idPlayer'])) continue;
            if(Right::canWrite($playerData)) {
                $player = PlayerStore::getById($playerData['idPlayer']);
                $player->edit(Right::writeableFields($playerData));
                $player->save();
                $ret->ajout($player);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new PlayerCollection();
            foreach ($queryBody as $playerData) {
                if (isset($playerData['idPlayer'])) continue;
                
                if (Right::canWrite($playerData)) {
                    $player = new Player();
                    $player->edit(Right::writeableFields($playerData));
                    $player->save();
                    $ret->ajout($player);
                }
            }
            return $this->filterCollection($ret);
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = PlayerStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = PlayerBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new PlayerCollection();
        foreach($ret as $player) {
            if(Right::canDelete($player)) $player->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(PlayerBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $players
     * @return array
     */
    public static function filterCollection(BaseCollection $players)
    {
        $ret = [];
        foreach ($players as $player) {
            if(Right::canSee($player)) $ret[] = Right::readableFields($player);
        }
        return $ret;
    }


}