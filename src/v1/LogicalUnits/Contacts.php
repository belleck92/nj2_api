<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-06-29
 * Time: 14:02:12
 */

namespace Fr\Nj2\Api\v1\LogicalUnits;

use Fr\Nj2\Api\models\business\ContactBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\ContactCollection;
use Fr\Nj2\Api\models\Contact;
use Fr\Nj2\Api\models\store\ContactStore;
use Fr\Nj2\Api\v1\LogicalUnit;
use Fr\Nj2\Api\v1\Rights\Contacts as Right;

class Contacts extends LogicalUnit
{
    /**
     * @var string
     */
    protected $tableName = 'contact';

    public function getByIds($ids)
    {
        return $this->filterCollection(ContactStore::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        $segments = explode('/', $queryString);
        if(count($segments) > 1) {
            switch ($segments[1]) {
                case 'societes':
                    return Societes::filterCollection(ContactStore::getByIds($segments[0])->getSocietes());
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
            if(Right::canWrite($contactData)) {
                $contact = ContactStore::getById($contactData['idContact']);
                $contact->edit(Right::writeableFields($contactData));
                $contact->save();
                $ret->ajout($contact);
            }
        }
        return $this->filterCollection($ret);
    }

    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new ContactCollection();
            foreach ($queryBody as $contactData) {
                if (isset($contactData['idContact'])) continue;
                if (!isset($contactData['idSociete'])) continue;
                if (Right::canWrite($contactData)) {
                    $contact = new Contact();
                    $contact->edit(Right::writeableFields($contactData));
                    $contact->save();
                    $ret->ajout($contact);
                }
            }
            return $this->filterCollection($ret);
        } elseif (preg_match('#^[0-9]+$#', $segments[0])) {
            if($segments[1] == "societes") {
                $unit = new Societes();
                $unit->create('', $parameters, $queryBody);
            }
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        if(preg_match('#^([0-9]+,?)+$#', $queryString)) $ret = ContactStore::getByIds($queryString);
        elseif($queryString == 'filter') {
            $ret = ContactBusiness::getFiltered($parameters);
            $ret->store();
        }
        else $ret = new ContactCollection();
        foreach($ret as $contact) {
            if(Right::canDelete($contact)) $contact->delete();
        }
        return $this->filterCollection($ret);
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
            if(Right::canSee($contact)) $ret[] = Right::readableFields($contact);
        }
        return $ret;
    }


}