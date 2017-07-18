<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\UserStore;
use Fr\Nj2\Api\models\extended\User;
use Fr\Nj2\Api\models\extended\Player;
use Fr\Nj2\Api\models\business\PlayerBusiness;

class UserCollection extends BaseCollection {

    /**
     * @var PlayerCollection|Player[]
     */
    private $cachePlayers = null;
    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param User $user
     */
    public function ajout(User $user) {
        parent::append($user);
    }

    /**
     * Met les Users de la collection dans le UserStore
     * Vérifie si le User était déjà storé, dans ce cas, remplace le User concerné par celui du UserStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$user) {/** @var User $user */
            if(UserStore::exists($user->getId())) $replaces[$offset] = $user;
            else UserStore::store($user);
        }
        unset($offset);
        foreach($replaces as $offset=>$user) {
            $this->offsetSet($offset, UserStore::getById($user->getId()));
        }
    }
    
    /**
     * Renvoie les Players liés aux Users de cette collection
     * @return PlayerCollection
     */
    public function getPlayers() {
        if(is_null($this->cachePlayers)) {
            $this->cachePlayers = PlayerBusiness::getFromUsers($this);
            $this->cachePlayers->store();
        }
        return $this->cachePlayers;
    }

    /**
    * Force la collection de players de this
    * @param PlayerCollection $players
    */
    public function setPlayers(PlayerCollection $players)
    {
        $this->cachePlayers = $players;
    }

    /**
    * Remet à null le cache des players liés à this
    */
    public function resetCachePlayers() {
        $this->cachePlayers = null;
    }

    /**
    * Distribue les Players fournis en paramètre à chaque User de la collection si le Player correspond.
    * @param PlayerCollection $players
    */
    public function fillPlayers(PlayerCollection $players)
    {
        foreach($this as $user) {/** @var User $user */
            $user->resetCachePlayers();
            $coll = new PlayerCollection();
            $user->setPlayers($coll);
            foreach($players as $player) {/** @var Player $player */
                if($player->getIdUser() == $user->getIdUser()) {
                    $coll->ajout($player);
                }
            }
        }
    }
    

    /**
     * @param mixed $index
     * @return User
     */
    public function offsetGet($index)
    {
        return parent::offsetGet($index);
    }
}