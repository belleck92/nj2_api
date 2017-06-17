<?php
/**
* Created by Manu
* Date: 2017-06-17
* Time: 17:54:25
*/

namespace Fr\Nj2\Api\models;


use Fr\Nj2\Api\models\business\ContactBusiness;
use Fr\Nj2\Api\models\store\SocieteStore;


class Contact implements Bean {

    /**
     * @var int
     */
    private $idContact;

    /**
     * @var int
     */
    private $idSociete = 0;

    /**
     * @var string
     */
    private $nom = '';

    /**
     * @var int
     */
    private $salaire = 0;

    /**
     * @return int
     */
    public function getIdContact()
    {
        return $this->idContact;
    }

    /**
     * @param int $idContact
     */
    public function setIdContact($idContact)
    {
        $this->idContact = $idContact;
    }
    
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
     * Incremente $this->idSociete de $increment
     * @param int $increment
     */
    public function incrIdSociete($increment) {
        $this->setIdSociete($this->getIdSociete() + $increment);
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
     * @return int
     */
    public function getSalaire()
    {
        return $this->salaire;
    }

    /**
     * @param int $salaire
     */
    public function setSalaire($salaire)
    {
        $this->salaire = $salaire;
    }
    
    /**
     * Incremente $this->salaire de $increment
     * @param int $increment
     */
    public function incrSalaire($increment) {
        $this->setSalaire($this->getSalaire() + $increment);
    }
    

    /**
     * Renvoie le societe lié
     * @return Societe
     */
    public function getSociete()
    {
        return SocieteStore::getById($this->getIdSociete());
    }

    /**
     * @return void
     */
    public function save()
    {
        ContactBusiness::save($this);
    }

    /**
     * @return int Id primaire du bean
     */
    public function getId()
    {
        return $this->getIdContact();
    }

    /**
     * @return void
     */
    public function delete()
    {
        ContactBusiness::delete($this);
    }

    /**
     * Sette le PK du bean
     * @param int $id
     */
    public function setId($id)
    {
        $this->setIdContact($id);
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        return [
            'idContact'=>$this->idContact
            ,'idSociete'=>$this->idSociete
            ,'nom'=>$this->nom
            ,'salaire'=>$this->salaire
        ];
    }
}