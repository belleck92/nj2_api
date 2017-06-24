<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 16/06/17
 * Time: 13:29
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\API;
use Fr\Nj2\Api\models\Bean;
use Fr\Nj2\Api\models\business\ContactBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\ContactCollection;
use Fr\Nj2\Api\models\Contact;
use Fr\Nj2\Api\models\store\ContactStore;
use Fr\Nj2\Api\v1\LogicalUnit;

class Contacts extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'contact';

    public function getByIds($ids)
    {
        return $this->filterCollection(ContactBusiness::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        $segments = explode('/', $queryString);
        if(count($segments) > 1) {
            switch ($segments[1]) {
                case 'societes':
                    return Societes::filterCollection(ContactBusiness::getByIds($segments[0])->getSocietes());
            }
        }
        return parent::get($queryString, $parameters);
    }

    public function update($queryString, $parameters, $queryBody)
    {
        if(!is_array($queryBody)) return [];
        $ret = new ContactCollection();
        foreach($queryBody as $contactData) {
            if(!isset($contactData['idContact'])) continue;
            if($this->canWrite($contactData)) {
                $contact = ContactStore::getById($contactData['idContact']);
                $contact->edit($this->writeableFields($contactData));
                $contact->save();
                $ret->ajout($contact);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        var_dump($segments);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new ContactCollection();
            foreach ($queryBody as $contactData) {
                if (isset($contactData['idContact'])) continue;
                if (!isset($contactData['idSociete'])) continue;
                if ($this->canWrite($contactData)) {
                    $contact = new Contact();
                    $contact->edit($this->writeableFields($contactData));
                    $contact->save();
                    $ret->ajout($contact);
                }
            }
            return $this->filterCollection($ret);
        } elseif (preg_match('#^[0-1]+$#', $segments[0])) {
            if($segments[1] == "societes") {
                $unit = new Societes();
                $unit->create('', $parameters, $queryBody);
            }
        }
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = ContactBusiness::getByIds($queryString);
        elseif($queryString == 'filter') $ret = ContactBusiness::getFiltered($parameters);
        else $ret = new ContactCollection();
        foreach($ret as $contact) {
            if(self::canDelete($contact)) $contact->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param Bean $contact
     * @return bool
     */
    public static function canSee(Bean $contact)
    {
        /** @var Contact $contact */
        return true;
    }

    /**
     * Returns the fields to be displayed
     * @param Bean $contact
     * @return array
     */
    public static function readableFields(Bean $contact)
    {
        /** @var Contact $contact */
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

    /**
     * @param array $parameters
     * @return array
     */
    public static function getFiltered($parameters)
    {
        return self::filterCollection(ContactBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $contacts
     * @return array
     */
    public static function filterCollection(BaseCollection $contacts)
    {
        $ret = [];
        foreach ($contacts as $contact) {
            if(self::canSee($contact)) $ret[] = self::readableFields($contact);
        }
        return $ret;
    }


}