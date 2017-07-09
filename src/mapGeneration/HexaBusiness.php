<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 09/07/17
 * Time: 11:37
 */

namespace Fr\Nj2\Api\mapGeneration;

use Fr\Nj2\Api\models\DbHandler;

class HexaBusiness extends \Fr\Nj2\Api\models\business\HexaBusiness
{

    /**
     * Renvoie le prochain Id d'hexa disponible dans la table
     * @return int
     */
    public static function getNextId(){
        $req = "SELECT MAX(idHexa) as maxou FROM hexa;";
        $res = DbHandler::query($req);
        $res = mysqli_fetch_assoc($res);
        return $res['maxou'] + 1;
    }
}