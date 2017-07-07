<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-07
 * Time: 17:53:41
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\GameBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\GameCollection;
use Fr\Nj2\Api\models\Game;
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