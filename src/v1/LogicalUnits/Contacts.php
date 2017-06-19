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

    /**
     * @param Contact $contact
     * @return bool
     */
    public function canSee(Contact $contact)
    {
        return true;
        //return API::getInstance()->getTokenData()['role'] == API::ROLE_ADMIN || $contact->getIdSociete() == API::getInstance()->getTokenData()['idSociete'];
    }

    /**
     * Returns the fields to be displayed
     * @param Bean $contact
     * @return array
     */
    public function fields(Bean $contact)
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

    public function getFiltered($parameters)
    {
        return $this->filterCollection(ContactBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $contacts
     * @return array
     */
    public function filterCollection(BaseCollection $contacts)
    {
        $ret = [];
        foreach ($contacts as $contact) {
            if($this->canSee($contact)) $ret[] = $this->fields($contact);
        }
        return $ret;
    }


}