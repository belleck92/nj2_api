<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-09
 * Time: 16:40:03
 */

namespace Fr\Nj2\Api\models\extended;

use Fr\Nj2\Api\models\collection\HexaCollection;
use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\store\HexaStore;

class Player extends \Fr\Nj2\Api\models\Player
{
    /**
     * @var HexaCollection
     */
    protected $cacheCities = null;

    /**
     * Remet à null le cache des hexas liés à this
     */
    public function resetCacheCities() {
        $this->cacheCities = null;
    }

    /**
     * Force la collection de villes de this
     * @param HexaCollection $hexas
     */
    public function setCities(HexaCollection $hexas)
    {
        $this->cacheCities = $hexas;
    }

    /**
     * Renvoie les villes liés à ce Player
     * @return HexaCollection|Hexa[]
     */
    public function getCities() {
        if(is_null($this->cacheCities)) {
            $this->cacheCities = DbHandler::collFromQuery("SELECT * FROM hexa WHERE idPlayer = '".$this->getId()."';", 'Hexa', 'HexaCollection');
            $this->cacheCities->store();
        }
        return $this->cacheCities;
    }

    /**
     * Creates the visibilities records for the player
     */
    public function initAllVisibilities()
    {
        $req = "INSERT INTO visibility(idPlayer, idHexa, level) SELECT ".$this->getId().", idHexa, ".Visibility::UNEXPLORED." FROM hexa WHERE idGame = ".$this->getIdGame().";";
        DbHandler::query($req);

        $req = "UPDATE visibility SET level = ".Visibility::VISIBLE." WHERE idPlayer = ".$this->getId()." AND idHexa IN (".HexaStore::getById($this->getCapitalCity())->getCouronnePleine(Parameter::val(Parameter::CITY_VISIBILITY_RADIUS))->getIdsStr().") ;";
        DbHandler::query($req);
    }

}