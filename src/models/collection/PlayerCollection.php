<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\PlayerStore;
use Fr\Nj2\Api\models\extended\Player;
use Fr\Nj2\Api\models\business\GameBusiness;
use Fr\Nj2\Api\models\extended\Game;
use Fr\Nj2\Api\models\business\UserBusiness;
use Fr\Nj2\Api\models\extended\User;
use Fr\Nj2\Api\models\extended\Visibility;
use Fr\Nj2\Api\models\business\VisibilityBusiness;
use Fr\Nj2\Api\models\extended\Hexa;
use Fr\Nj2\Api\models\business\HexaBusiness;

class PlayerCollection extends BaseCollection {

    /**
     * @var VisibilityCollection|Visibility[]
     */
    private $cacheVisibilitys = null;
    /**
     * @var HexaCollection|Hexa[]
     */
    private $cacheHexas = null;
    
    /**
     * @var GameCollection|Game[]
     */
    private $cacheGames = null;
    
    /**
     * @var UserCollection|User[]
     */
    private $cacheUsers = null;
    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Player $player
     */
    public function ajout(Player $player) {
        parent::append($player);
    }

    /**
     * Met les Players de la collection dans le PlayerStore
     * Vérifie si le Player était déjà storé, dans ce cas, remplace le Player concerné par celui du PlayerStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$player) {/** @var Player $player */
            if(PlayerStore::exists($player->getId())) $replaces[$offset] = $player;
            else PlayerStore::store($player);
        }
        unset($offset);
        foreach($replaces as $offset=>$player) {
            $this->offsetSet($offset, PlayerStore::getById($player->getId()));
        }
    }
    
    /**
     * Renvoie les Visibilitys liés aux Players de cette collection
     * @return VisibilityCollection
     */
    public function getVisibilitys() {
        if(is_null($this->cacheVisibilitys)) {
            $this->cacheVisibilitys = VisibilityBusiness::getFromPlayers($this);
            $this->cacheVisibilitys->store();
        }
        return $this->cacheVisibilitys;
    }

    /**
    * Force la collection de visibilitys de this
    * @param VisibilityCollection $visibilitys
    */
    public function setVisibilitys(VisibilityCollection $visibilitys)
    {
        $this->cacheVisibilitys = $visibilitys;
    }

    /**
    * Remet à null le cache des visibilitys liés à this
    */
    public function resetCacheVisibilitys() {
        $this->cacheVisibilitys = null;
    }

    /**
    * Distribue les Visibilitys fournis en paramètre à chaque Player de la collection si le Visibility correspond.
    * @param VisibilityCollection $visibilitys
    */
    public function fillVisibilitys(VisibilityCollection $visibilitys)
    {
        foreach($this as $player) {/** @var Player $player */
            $player->resetCacheVisibilitys();
            $coll = new VisibilityCollection();
            $player->setVisibilitys($coll);
            foreach($visibilitys as $visibility) {/** @var Visibility $visibility */
                if($visibility->getIdPlayer() == $player->getIdPlayer()) {
                    $coll->ajout($visibility);
                }
            }
        }
    }
    
    /**
     * Renvoie les Hexas liés aux Players de cette collection
     * @return HexaCollection
     */
    public function getHexas() {
        if(is_null($this->cacheHexas)) {
            $this->cacheHexas = HexaBusiness::getFromPlayers($this);
            $this->cacheHexas->store();
        }
        return $this->cacheHexas;
    }

    /**
    * Force la collection de hexas de this
    * @param HexaCollection $hexas
    */
    public function setHexas(HexaCollection $hexas)
    {
        $this->cacheHexas = $hexas;
    }

    /**
    * Remet à null le cache des hexas liés à this
    */
    public function resetCacheHexas() {
        $this->cacheHexas = null;
    }

    /**
    * Distribue les Hexas fournis en paramètre à chaque Player de la collection si le Hexa correspond.
    * @param HexaCollection $hexas
    */
    public function fillHexas(HexaCollection $hexas)
    {
        foreach($this as $player) {/** @var Player $player */
            $player->resetCacheHexas();
            $coll = new HexaCollection();
            $player->setHexas($coll);
            foreach($hexas as $hexa) {/** @var Hexa $hexa */
                if($hexa->getIdTerritory() == $player->getIdPlayer()) {
                    $coll->ajout($hexa);
                }
            }
        }
    }
    
    /**
     * Remet à null le cache des Games liés à la collection
     */
    public function resetCacheGames() {
        $this->cacheGames = null;
    }

    /**
     * Renvoie les Games liés aux Players de cette collection
     * @return GameCollection
     */
    public function getGames(){
        if(is_null($this->cacheGames)) {
        $this->cacheGames = GameBusiness::getFromPlayers($this);
            $this->cacheGames->store();
        }
        return $this->cacheGames;
    }
       
    /**
     * Renvoie une chaîne d'idGame de la collection
     * @return string
     */  
    public function getIdGameStr() {
        $ret = '';
        $prem = true;
        foreach($this as $player) {
            if(!$prem) $ret .=',';
            $prem = false;
            $ret .= $player->getIdGame();
        }
        return $ret;
    }
    
    /**
     * Remet à null le cache des Users liés à la collection
     */
    public function resetCacheUsers() {
        $this->cacheUsers = null;
    }

    /**
     * Renvoie les Users liés aux Players de cette collection
     * @return UserCollection
     */
    public function getUsers(){
        if(is_null($this->cacheUsers)) {
        $this->cacheUsers = UserBusiness::getFromPlayers($this);
            $this->cacheUsers->store();
        }
        return $this->cacheUsers;
    }
       
    /**
     * Renvoie une chaîne d'idUser de la collection
     * @return string
     */  
    public function getIdUserStr() {
        $ret = '';
        $prem = true;
        foreach($this as $player) {
            if(!$prem) $ret .=',';
            $prem = false;
            $ret .= $player->getIdUser();
        }
        return $ret;
    }
    

    /**
     * @param mixed $index
     * @return Player
     */
    public function offsetGet($index)
    {
        return parent::offsetGet($index);
    }
}