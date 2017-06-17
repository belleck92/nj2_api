<?php
/**
* Created by Manu
* Date: 2017-06-17
* Time: 17:54:25
*/
namespace Fr\Nj2\Api\models\collection;

use Fr\Nj2\Api\models\Bean;

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
}