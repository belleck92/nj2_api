<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 29/06/17
 * Time: 13:27
 */

namespace Fr\Nj2\Api\v1\Rights;


use Fr\Nj2\Api\API;
use Fr\Nj2\Api\models\Bean;
use Fr\Nj2\Api\models\business\ContactBusiness;
use Fr\Nj2\Api\models\Contact;
use Fr\Nj2\Api\models\store\ContactStore;
use Fr\Nj2\Api\v1\Right;

class Contacts extends Right
{
    /**
     * @param Bean $bean
     * @return bool
     */
    public static function canSee(Bean $bean)
    {
        /** @var Contact $bean */
        return true;
    }

    /**
     * Returns the fields to be displayed
     * @param Contact $contact
     * @return array
     */
    public static function readableFields(Contact $contact)
    {
        if(API::getInstance()->getToken()['role'] == API::ROLE_ADMIN) return $contact->getAsArray();
        elseif (API::getInstance()->getToken()['role'] == API::ROLE_PLAYER && API::getInstance()->getToken()['idSociete'] == $contact->getIdSociete()) return array_intersect_key($contact->getAsArray(),array_flip([
            'idContact'
            ,'idSociete'
            ,'nom'
            ,'salaire'
        ]));
        else return array_intersect_key($contact->getAsArray(),array_flip([
            'idContact'
            ,'idSociete'
            ,'nom'
        ]));
    }

    /**
     * @param array $data
     * @return bool
     */
    public static function canWrite($data)
    {
        if(API::getInstance()->getToken()['role'] == API::ROLE_ADMIN) return true;
        if(isset($data['idSociete']) && $data['idSociete'] != API::getInstance()->getToken()['idSociete']) return false;
        return true;
    }

    /**
     * @param array $data
     * @return array
     */
    public static function writeableFields($data)
    {
        if(API::getInstance()->getToken()['role'] == API::ROLE_ADMIN || (isset($data['idSociete']) && $data['idSociete'] == API::getInstance()->getToken()['idSociete'])) return array_intersect_key($data,array_flip(ContactBusiness::getFields()));
        elseif(!isset($data['idSociete']) && isset($data['idContact'])) {
            $contact = ContactStore::getById($data['idContact']);
            if(API::getInstance()->getToken()['idSociete'] == $contact->getIdSociete()) return array_intersect_key($data,array_flip(ContactBusiness::getFields()));
            else return [];
        }
        else return [];
    }

    /**
     * @param Contact $contact
     * @return bool
     */
    public static function canDelete($contact)
    {
        if(API::getInstance()->getToken()['role'] == API::ROLE_ADMIN) return true;
        if($contact->getIdSociete() != API::getInstance()->getToken()['idSociete']) return false;
        return true;
    }
}