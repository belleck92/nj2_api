<?php
/**
* Created by Manu
* Date: 2017-07-09
* Time: 17:30:19
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\store\UserStore;
use Fr\Nj2\Api\models\extended\User;

class UserCollection extends BaseCollection {

    
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
     * @param mixed $index
     * @return User
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}