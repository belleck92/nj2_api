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