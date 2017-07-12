<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-09
 * Time: 16:40:03
 */

namespace Fr\Nj2\Api\models\extended;

class Resource extends \Fr\Nj2\Api\models\Resource
{

    public function getAsArray()
    {
        $ret = parent::getAsArray();
        if($this->extendedData) {
            $ret['name'] = $this->getTypeResource()->getName();
        }
        return $ret;
    }
}