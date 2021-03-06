<?php
/**
* Created by Manu
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\Bean;
use Fr\Nj2\Api\models\collection\BaseCollection;
use Fr\Nj2\Api\models\DbHandler;

class BaseCollection extends \ArrayObject {

    /**
     * Renvoie les Ids des objets de la collection, séparés par des virgules, châine vide si collection vide
     * @return string
     */
    public function getIdsStr(){
        $ret = '';
        $prem = true;
        foreach($this as $obj) {/** @var Bean $obj */
            if(!$prem) $ret .= ',';
            $prem = false;
            $ret .= $obj->getId();
        }
        return $ret;
    }

    /**
     * Stores the objects of the collection
     */
    public function store() {

    }

    /**
     * Dit si l'objet existe dans la collection
     * @param Bean $bean
     * @return bool
    */
    public function exists(Bean $bean)
    {
        foreach($this as $obj) {/** @var Bean $obj */
            if($obj->getId() == $bean->getId()) return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getAsArray()
    {
        $ret = [];
        foreach($this as $bean) {/** @var Bean $bean */
            $ret[] = $bean->getAsArray();
        }
        return $ret;
    }
}