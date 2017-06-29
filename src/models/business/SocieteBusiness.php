<?php
/**
* Created by Manu
* Date: 2017-06-29
* Time: 14:02:30
*/
namespace Fr\Nj2\Api\models\business;

use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\Societe;
use Fr\Nj2\Api\models\collection\SocieteCollection;
use Fr\Nj2\Api\models\collection\ContactCollection;


class SocieteBusiness extends BaseBusiness {

    protected static $fields = array(
        'idSociete'
        ,'nom'
    );

    protected static $table = 'societe';

    /**
     * Renvoie le Societe demandé
     * @var int $id Id primaire du Societe
     * @return Societe
     */
    public static function getById($id) {
        return parent::getById($id);
    }

    /**
     * @param string $ids
     * @return SocieteCollection
     */
    public static function getByIds($ids)
    {
        return parent::getByIds($ids);
    }

    
    
    /**
     * Renvoie les Societes liés à une collection de Contacts
     * @param ContactCollection $contacts
     * @return SocieteCollection|Societe[]
     */
    public static function getFromContacts(ContactCollection $contacts){
        $ids = $contacts->getIdSocieteStr();
        if(!$ids) return new SocieteCollection();
        $req = "SELECT * FROM societe WHERE idSociete IN (".$ids.");";
        return DbHandler::collFromQuery($req, 'Societe', 'SocieteCollection');
    }
 /**
     * Supprime le Societe en DB
     * @param Societe $societe
     */
    public static function delete(Societe $societe) {
        $req = "DELETE FROM `societe` WHERE `idSociete` = '".$societe->getId()."';";
        DbHandler::delete($req);
    }
}
