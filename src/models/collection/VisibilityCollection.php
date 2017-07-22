<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\VisibilityStore;
use Fr\Nj2\Api\models\extended\Visibility;
use Fr\Nj2\Api\models\business\HexaBusiness;
use Fr\Nj2\Api\models\extended\Hexa;
use Fr\Nj2\Api\models\business\PlayerBusiness;
use Fr\Nj2\Api\models\extended\Player;

class VisibilityCollection extends BaseCollection {

    
    /**
     * @var HexaCollection|Hexa[]
     */
    private $cacheHexas = null;
    
    /**
     * @var PlayerCollection|Player[]
     */
    private $cachePlayers = null;
    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Visibility $visibility
     */
    public function ajout(Visibility $visibility) {
        parent::append($visibility);
    }

    /**
     * Met les Visibilitys de la collection dans le VisibilityStore
     * Vérifie si le Visibility était déjà storé, dans ce cas, remplace le Visibility concerné par celui du VisibilityStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$visibility) {/** @var Visibility $visibility */
            if(VisibilityStore::exists($visibility->getId())) $replaces[$offset] = $visibility;
            else VisibilityStore::store($visibility);
        }
        unset($offset);
        foreach($replaces as $offset=>$visibility) {
            $this->offsetSet($offset, VisibilityStore::getById($visibility->getId()));
        }
    }
    
    /**
     * Remet à null le cache des Hexas liés à la collection
     */
    public function resetCacheHexas() {
        $this->cacheHexas = null;
    }

    /**
     * Renvoie les Hexas liés aux Visibilitys de cette collection
     * @return HexaCollection
     */
    public function getHexas(){
        if(is_null($this->cacheHexas)) {
        $this->cacheHexas = HexaBusiness::getFromVisibilitys($this);
            $this->cacheHexas->store();
        }
        return $this->cacheHexas;
    }
       
    /**
     * Renvoie une chaîne d'idHexa de la collection
     * @return string
     */  
    public function getIdHexaStr() {
        $ret = '';
        $prem = true;
        foreach($this as $visibility) {
            if(!$prem) $ret .=',';
            $prem = false;
            $ret .= $visibility->getIdHexa();
        }
        return $ret;
    }
    
    /**
     * Remet à null le cache des Players liés à la collection
     */
    public function resetCachePlayers() {
        $this->cachePlayers = null;
    }

    /**
     * Renvoie les Players liés aux Visibilitys de cette collection
     * @return PlayerCollection
     */
    public function getPlayers(){
        if(is_null($this->cachePlayers)) {
        $this->cachePlayers = PlayerBusiness::getFromVisibilitys($this);
            $this->cachePlayers->store();
        }
        return $this->cachePlayers;
    }
       
    /**
     * Renvoie une chaîne d'idPlayer de la collection
     * @return string
     */  
    public function getIdPlayerStr() {
        $ret = '';
        $prem = true;
        foreach($this as $visibility) {
            if(!$prem) $ret .=',';
            $prem = false;
            $ret .= $visibility->getIdPlayer();
        }
        return $ret;
    }
    

    /**
     * @param mixed $index
     * @return Visibility
     */
    public function offsetGet($index)
    {
        return parent::offsetGet($index);
    }
}