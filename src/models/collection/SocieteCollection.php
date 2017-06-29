<?php
/**
* Created by Manu
* Date: 2017-06-27
* Time: 13:43:14
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\Societe;
use Fr\Nj2\Api\models\store\SocieteStore;
use Fr\Nj2\Api\models\Contact;
use Fr\Nj2\Api\models\business\ContactBusiness;

class SocieteCollection extends BaseCollection {

    /**
     * @var ContactCollection|Contact[]
     */
    private $cacheContacts = null;
    
    /**
     * Ajoute un objet à la collection en vérifiant le type
     * @param Societe $societe
     */
    public function ajout(Societe $societe) {
        parent::append($societe);
    }

    /**
     * Met les Societes de la collection dans le SocieteStore
     * Vérifie si le Societe était déjà storé, dans ce cas, remplace le Societe concerné par celui du SocieteStore
     */
    public function store()
    {
        $replaces = array();
        foreach($this as $offset=>$societe) {/** @var Societe $societe */
            if(SocieteStore::exists($societe->getId())) $replaces[$offset] = $societe;
            else SocieteStore::store($societe);
        }
        unset($offset);
        foreach($replaces as $offset=>$societe) {
            $this->offsetSet($offset, SocieteStore::getById($societe->getId()));
        }
    }
    
    /**
     * Renvoie les Contacts liés aux Societes de cette collection
     * @return ContactCollection|Contact[]
     */
    public function getContacts() {
        if(is_null($this->cacheContacts)) {
            $this->cacheContacts = ContactBusiness::getFromSocietes($this);
            $this->cacheContacts->store();
        }
        return $this->cacheContacts;
    }

    /**
    * Force la collection de contacts de this
    * @param ContactCollection $contacts
    */
    public function setContacts(ContactCollection $contacts)
    {
        $this->cacheContacts = $contacts;
    }

    /**
    * Remet à null le cache des contacts liés à this
    */
    public function resetCacheContacts() {
        $this->cacheContacts = null;
    }

    /**
    * Distribue les Contacts fournis en paramètre à chaque Societe de la collection si le Contact correspond.
    * @param ContactCollection $contacts
    */
    public function fillContacts(ContactCollection $contacts)
    {
        foreach($this as $societe) {/** @var Societe $societe */
            $societe->resetCacheContacts();
            $coll = new ContactCollection();
            $societe->setContacts($coll);
            foreach($contacts as $contact) {
                if($contact->getIdSociete() == $societe->getIdSociete()) {
                    $coll->ajout($contact);
                }
            }
        }
    }
    

    /**
     * @param mixed $index
     * @return Societe
     */
    public function offsetGet($index)
    {
        parent::offsetGet($index);
    }
}