<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\HexaBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\HexaCollection;
use Fr\Nj2\Api\models\extended\Hexa;
use Fr\Nj2\Api\models\store\HexaStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Hexas as Right;
use Fr\Nj2\Api\v1\Extended\Games;
use Fr\Nj2\Api\v1\Extended\TypeClimates;
use Fr\Nj2\Api\v1\Extended\Resources;
use Fr\Nj2\Api\v1\Extended\Rivers;

class Hexas extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'hexa';

    public function getByIds($ids)
    {
        return $this->filterCollection(HexaStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        $segments = explode('/', $queryString);
        if(count($segments) > 1) {
            switch ($segments[1]) {
                case 'games':
                    return Games::filterCollection(HexaStore::getByIds($segments[0])->getGames());
            
                case 'typeClimates':
                    return TypeClimates::filterCollection(HexaStore::getByIds($segments[0])->getTypeClimates());
            
                case 'resources':
                    return Resources::filterCollection(HexaStore::getByIds($segments[0])->getResources());
        
                case 'rivers':
                    return Rivers::filterCollection(HexaStore::getByIds($segments[0])->getRivers());
        }}
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new HexaCollection();
        foreach($queryBody as $hexaData) {
            if(!isset($hexaData['idHexa'])) continue;
            if(Right::canWrite($hexaData)) {
                $hexa = HexaStore::getById($hexaData['idHexa']);
                $hexa->edit(Right::writeableFields($hexaData));
                $hexa->save();
                $ret->ajout($hexa);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new HexaCollection();
            foreach ($queryBody as $hexaData) {
                if (isset($hexaData['idHexa'])) continue;
                if (!isset($hexaData['idGame'])) continue;
                if (!isset($hexaData['idTypeClimate'])) continue;
                if (Right::canWrite($hexaData)) {
                    $hexa = new Hexa();
                    $hexa->edit(Right::writeableFields($hexaData));
                    $hexa->save();
                    $ret->ajout($hexa);
                }
            }
            return $this->filterCollection($ret);
        } elseif (preg_match('#^[0-9]+$#', $segments[0])) {
            if($segments[1] == "resources") {
                foreach ($queryBody as &$resource) {
                    $resource['idHexa'] = $segments[0];
                }
                $unit = new Resources();
                return $unit->create('', $parameters, $queryBody);
            }
            if($segments[1] == "rivers") {
                foreach ($queryBody as &$river) {
                    $river['idHexa'] = $segments[0];
                }
                $unit = new Rivers();
                return $unit->create('', $parameters, $queryBody);
            }
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = HexaStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = HexaBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new HexaCollection();
        foreach($ret as $hexa) {
            if(Right::canDelete($hexa)) $hexa->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(HexaBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $hexas
     * @return array
     */
    public static function filterCollection(BaseCollection $hexas)
    {
        $ret = [];
        foreach ($hexas as $hexa) {
            if(Right::canSee($hexa)) $ret[] = Right::readableFields($hexa);
        }
        return $ret;
    }


}