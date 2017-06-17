<?php
/**
* Created by Manu
* Date: 2017-06-16
* Time: 17:46:45
*/

namespace Fr\Nj2\Api\models;


use Fr\Nj2\Api\models\business\SocieteBusiness;
use Fr\Nj2\Api\models\collection\ContactCollection;
use Fr\Nj2\Api\models\business\ContactBusiness;


class Societe implements Bean {

    /**
     * @var int
     */
    private $idSociete;

    /**
     * @var string
     */
    private $nom = '';

    /**
     * @var ContactCollection|Contact[]
     */
    private $cacheContacts = null;

    /**
     * @return int
     */
    public function getIdSociete()
    {
        return $this->idSociete;
    }

    /**
     * @param int $idSociete
     */
    public function setIdSociete($idSociete)
    {
        $this->idSociete = $idSociete;
    }
    
    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }
    
    /**
     * Remet à null le cache des contacts liés à this
     */
    public function resetCacheContacts() {
        $this->cacheContacts = null;
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
     * Renvoie les contacts liés à ce Societe
     * @return ContactCollection|Contact[]
     */
    public function getContacts() {
        if(is_null($this->cacheContacts)) {
            $this->cacheContacts = ContactBusiness::getBySociete($this);
            $this->cacheContacts->store();
        }
        return $this->cacheContacts;
    }

    /**
     * Crée un contact lié à ce Societe
     * @return Contact
     */
    public function createContact(){
        $contact = new Contact();
        $contact->setIdSociete($this->getIdSociete());
        return $contact;
    }

    /**
     * @return void
     */
    public function save()
    {
        SocieteBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdSociete();
    }

    /**
     * @return void
     */
    public function delete()
    {
        SocieteBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdSociete($id);
    }
}