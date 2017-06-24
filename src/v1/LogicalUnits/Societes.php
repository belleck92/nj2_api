<?php
use Fr\Nj2\Api\models\collection\SocieteCollection;

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
use Fr\Nj2\Api\models\business\SocieteBusiness;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\collection\SocieteCollection;
use Fr\Nj2\Api\models\Societe;
use Fr\Nj2\Api\v1\LogicalUnit;

class Societes extends LogicalUnit
{

    /**
     * @var string
     */
    protected $tableName = 'societe';

    public function getByIds($ids)
    {
        return $this->filterCollection(SocieteBusiness::getByIds($ids));
    }

    public function get($queryString, $parameters)
    {
        $segments = explode('/', $queryString);
        if(count($segments) > 1) {
            switch ($segments[1]) {
                case 'contacts':
                    return Contacts::filterCollection(SocieteBusiness::getByIds($segments[0])->getContacts());
            }
        }
        return parent::get($queryString, $parameters);
    }


    public function create($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(empty($segments[0])) {
            if (!is_array($queryBody)) return [];
            $ret = new SocieteCollection();
            foreach ($queryBody as $societeData) {
                if (isset($societeData['idSociete'])) continue;
                if ($this->canWrite($societeData)) {
                    $societe = new Societe();
                    $societe->edit($this->writeableFields($societeData));
                    $societe->save();
                    $ret->ajout($societe);
                }
            }
            return $this->filterCollection($ret);
        } elseif (preg_match('#^[0-9]+$#', $segments[0])) {
            if($segments[1] == "contacts") {
                foreach ($queryBody as &$contact) {
                    $contact['idSociete'] = $segments[0];
                }
                $unit = new Contacts();
                return $unit->create('', $parameters, $queryBody);
            }
        }
        return [];
    }

    public function delete($queryString, $parameters, $queryBody)
    {
        $segments = explode('/', $queryString);
        if(preg_match('#^([0-9]+,?)+$#', $segments[0])) {
            $ret = SocieteBusiness::getByIds($segments[0]);
            if($segments[1] == "contacts") {
                $ret = $ret->getContacts();
                $unit = new Contacts();
                return $unit->delete($ret->getIdsStr(), $parameters, $queryBody);
            }
        }
        elseif($queryString == 'filter') $ret = SocieteBusiness::getFiltered($parameters);
        else $ret = new SocieteCollection();
        foreach($ret as $societe) {
            if(self::canDelete($societe)) $societe->delete();
        }
        return $this->filterCollection($ret);
    }

    /**
     * @param Societe $societe
     * @return bool
     */
    public static function canDelete($societe)
    {
        if(API::getInstance()->getToken()['role'] == API::ROLE_ADMIN) return true;
        if($societe->getIdSociete() != API::getInstance()->getToken()['idSociete']) return false;
        return true;
    }

    /**
     * @param Bean $societe
     * @return bool
     */
    public static function canSee(Bean $societe)
    {
        /** @var Societe $societe */
        return true;
    }

    /**
     * Returns the fields to be displayed
     * @param Bean $societe
     * @return array
     */
    public static function readableFields(Bean $societe)
    {
        /** @var Societe $societe */
        return $societe->getAsArray();
    }

    public static function getFiltered($parameters)
    {
        return self::filterCollection(SocieteBusiness::getFiltered($parameters));
    }

    /**
     * @param BaseCollection $societes
     * @return array
     */
    public static function filterCollection(BaseCollection $societes)
    {
        /** @var SocieteCollection $societes */
        $ret = [];
        foreach ($societes as $societe) {
            if(self::canSee($societe)) $ret[] = self::readableFields($societe);
        }
        return $ret;
    }
}