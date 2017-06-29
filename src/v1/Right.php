<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 29/06/17
 * Time: 13:28
 */

namespace Fr\Nj2\Api\v1;

use Fr\Nj2\Api\models\Bean;

abstract class Right
{

    /**
     * @param Bean $bean
     * @return bool
     */
    public static function canSee(Bean $bean)
    {
        return false;
    }

    /**
     * Returns the fields to be displayed
     * @param Bean $bean
     * @return array
     */
    public static function readableFields(Bean $bean)
    {
        return [];
    }

    /**
     * @param array $data
     * @return bool
     */
    public static function canWrite($data)
    {
        return false;
    }

    /**
     * @param array $data
     * @return array
     */
    public static function writeableFields($data)
    {
        return [];
    }

    /**
     * @param Bean $bean
     * @return bool
     */
    public static function canDelete($bean)
    {
        return false;
    }
}