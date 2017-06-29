<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 29/06/17
 * Time: 13:36
 */

namespace Fr\Nj2\Api\v1\Rights;

use Fr\Nj2\Api\API;
use Fr\Nj2\Api\models\Societe;
use Fr\Nj2\Api\v1\Right;

class Societes extends Right
{
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
     * @param Societe $societe
     * @return bool
     */
    public static function canSee(Societe $societe)
    {
        return true;
    }

    /**
     * Returns the fields to be displayed
     * @param Societe $societe
     * @return array
     */
    public static function readableFields(Societe $societe)
    {
        /** @var Societe $societe */
        return $societe->getAsArray();
    }
}