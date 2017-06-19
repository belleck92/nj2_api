<?php
/**
* Created by Manu
* Date: 2017-06-19
* Time: 18:26:05
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\Contact;
use Fr\Nj2\Api\models\collection\ContactCollection;
use Fr\Nj2\Api\models\collection\SocieteCollection;
use Fr\Nj2\Api\models\Societe;


class ContactBusiness extends BaseBusiness {

    protected static $fields = array(
        'idContact'
        ,'idSociete'
        ,'nom'
        ,'salaire'
    );

    protected static $table = 'contact';

    /**
     * Renvoie le Contact demandé
     * @var int $id Id primaire du Contact
     * @return Contact
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return ContactCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
    /**
     * Renvoie les Contacts liés aux Societes de la collection fournie en paramètre
     * @param SocieteCollection $societes
     * @return ContactCollection|Contact[]
     */
    public static function getFromSocietes(SocieteCollection $societes){
        $ids = $societes->getIdsStr();
        if(!$ids) return new ContactCollection();
        $req = "SELECT * FROM contact WHERE idSociete IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'Contact', 'ContactCollection');
    }

    /**
     * Renvoie les Contacts liés à un Societe
     * @param Societe $societe
     * @return ContactCollection|Contact[]
     */
    public static function getBySociete(Societe $societe){
        $req = "SELECT * FROM contact WHERE idSociete = '".$societe->getId()."';";
        return DbHandler::collFromQuery($req, 'Contact', 'ContactCollection');
    }
    
     /**
     * Supprime le Contact en DB
     * @param Contact $contact
     */
    public static function delete(Contact $contact) {
        $req = "DELETE FROM `contact` WHERE `idContact` = '".$contact->getId()."';";
        DbHandler::delete($req);
    }
}
