<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-12
 * Time: 11:44:57
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\GameBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\GameCollection;
use Fr\Nj2\Api\models\extended\Game;
use Fr\Nj2\Api\models\store\GameStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Games as Right;

class Games extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'game';

    public function getByIds($ids)
    {
        return $this->filterCollection(GameStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        $segments = explode('/', $queryString);
        if(count($segments) > 1) {
            switch ($segments[1]) {
                case 'hexas':
                    return Hexas::filterCollection(GameStore::getByIds($segments[0])->getHexas());
        }}
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new GameCollection();
        foreach($queryBody as $gameData) {
            if(!isset($gameData['idGame'])) continue;
            if(Right::canWrite($gameData)) {
                $game = GameStore::getById($gameData['idGame']);
                $game->edit(Right::writeableFields($gameData));
                $game->save();
                $ret->ajout($game);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new GameCollection();
            foreach ($queryBody as $gameData) {
                if (isset($gameData['idGame'])) continue;
                
                if (Right::canWrite($gameData)) {
                    $game = new Game();
                    $game->edit(Right::writeableFields($gameData));
                    $game->save();
                    $ret->ajout($game);
                }
            }
            return $this->filterCollection($ret);
        } elseif (preg_match('#^[0-9]+$#', $segments[0])) {
            
            if($segments[1] == "hexas") {
                foreach ($queryBody as &$hexa) {
                    $hexa['idGame'] = $segments[0];
                }
                $unit = new Hexas();
                return $unit->create('', $parameters, $queryBody);
            }

            
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = GameStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = GameBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new GameCollection();
        foreach($ret as $game) {
            if(Right::canDelete($game)) $game->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(GameBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $games
     * @return array
     */
    public static function filterCollection(BaseCollection $games)
    {
        $ret = [];
        foreach ($games as $game) {
            if(Right::canSee($game)) $ret[] = Right::readableFields($game);
        }
        return $ret;
    }


}