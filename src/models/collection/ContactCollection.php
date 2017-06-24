<?php
/**
* Created by Manu
* Date: 2017-06-24
* Time: 14:27:39
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\Contact;
use Fr\Nj2\Api\models\store\ContactStore;
use Fr\Nj2\Api\models\business\SocieteBusiness;
use Fr\Nj2\Api\models\Societe;

class ContactCollection extends BaseCollection {

    
    /**
     * @var SocieteCollection|Societe[]
     */
    private $cacheSocietes = null;
    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Contact $contact
     */
    public function ajout(Contact $contact) {
        parent::append($contact);
    }

    /**
     * Met les Contacts de la collection dans le ContactStore
     * Vérifie si le Contact était déjà storé, dans ce cas, remplace le Contact concerné par celui du ContactStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$contact) {/** @var Contact $contact */
            if(ContactStore::exists($contact->getId())) $replaces[$offset] = $contact;
            else ContactStore::store($contact);
        }
        unset($offset);
        foreach($replaces as $offset=>$contact) {
            $this->offsetSet($offset, ContactStore::getById($contact->getId()));
        }
    }
    
    /**
     * Remet à null le cache des Societes liés à la collection
     */
    public function resetCacheSocietes() {
        $this->cacheSocietes = null;
    }

    /**
     * Renvoie les Societes liés aux Contacts de cette collection
     * @return SocieteCollection|Societe[]
     */
    public function getSocietes(){
        if(is_null($this->cacheSocietes)) {
        $this->cacheSocietes = SocieteBusiness::getFromContacts($this);
            $this->cacheSocietes->store();
        }
        return $this->cacheSocietes;
    }
       
    /**
     * Renvoie une chaîne d'idSociete de la collection
     * @return string
     */  
    public function getIdSocieteStr() {
        $ret = '';
        $prem = true;
        foreach($this as $contact) {
            if(!$prem) $ret .=',';
            $prem = false;
            $ret .= $contact->getIdSociete();
        }
        return $ret;
    }
    

    /**
     * @param mixed $index
     * @return Contact
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}