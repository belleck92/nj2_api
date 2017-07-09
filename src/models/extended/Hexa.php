<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-09
 * Time: 16:40:03
 */

namespace Fr\Nj2\Api\models\extended;

use Fr\Nj2\Api\models\collection\HexaCollection;

class Hexa extends \Fr\Nj2\Api\models\Hexa
{
    /**
     * @var int
     */
    private $vegetation = 0;

    /**
     * @var int
     */
    private $altitude = 0;

    /**
     * @return int
     */
    public function getVegetation()
    {
        return $this->vegetation;
    }

    /**
     * @param int $vegetation
     */
    public function setVegetation($vegetation)
    {
        $this->vegetation = $vegetation;
    }

    /**
     * @return int
     */
    public function getAltitude()
    {
        return $this->altitude;
    }

    /**
     * @param int $altitude
     */
    public function setAltitude($altitude)
    {
        $this->altitude = $altitude;
    }

    /**
     * Renvoie les hexas dans la couronne à la distance $rayon de la case
     * @param $rayon
     * @return HexaCollection
     */
    public function getCouronne($rayon)
    {
        $ret = new HexaCollection();
        if($rayon == 0) {
            $ret->ajout($this);
        } else {
            $coordsCourantes = array($this->getX(),$this->getY());
            for($i=1;$i<=$rayon;$i++) {
                $coordsCourantes = self::getCoordsVoisins($coordsCourantes[0],$coordsCourantes[1],4);
            }
            for($angle=0;$angle<=5;$angle++) {
                for($dist=0;$dist<$rayon;$dist++) {
                    $hexa = $this->getGame()->getHexaByCoords($coordsCourantes[0],$coordsCourantes[1]);
                    if(!is_null($hexa)) $ret->ajout($hexa);
                    $coordsCourantes = self::getCoordsVoisins($coordsCourantes[0],$coordsCourantes[1],$angle);
                }
            }
        }
        return $ret;
    }

    /**
     * Renvoie le voisin demandé
     * @param int $angle Angle en pi/3 avec 0=hexagone de droite
     * @return Hexa Ou null si on est sur un bord
     */
    public function getVoisin($angle)
    {
        if($angle == 6) $angle = 0;
        if($angle == -1) $angle = 5;
        $coords = self::getCoordsVoisins($this->getX(),$this->getY(),$angle);
        return $this->getGame()->getHexaByCoords($coords[0],$coords[1]);
    }

    /**
     * Renvoie tous les voisins de this
     * @return HexaCollection
     */
    public function voisins()
    {
        $ret = new HexaCollection();
        for($i=0;$i<=5;$i++) {
            if(!is_null($this->getVoisin($i))) $ret->ajout($this->getVoisin($i));
        }
        return $ret;
    }

    /**
     * Renvoie le x et le y du voisin demandé par rapport à un x et un y. Coordonnées pures, sans correction de bords
     * @param int $xBase
     * @param int $yBase
     * @param int $angle Angle en pi/3 avec 0=hexagone de droite
     * @return array
     */
    public static function getCoordsVoisins($xBase, $yBase, $angle)
    {
        switch($angle) {
            case 0:
                $yVoisin = $yBase;
                $xVoisin = $xBase + 1;
                break;
            case 1:
                $yVoisin = $yBase - 1;
                if(fmod($yBase,2) == 1) {
                    $xVoisin = $xBase;
                } else {
                    $xVoisin = $xBase + 1;
                }
                break;
            case 2:
                $yVoisin = $yBase - 1;
                if(fmod($yBase,2) == 1) {
                    $xVoisin = $xBase - 1;
                } else {
                    $xVoisin = $xBase;
                }
                break;
            case 3:
                $yVoisin = $yBase;
                $xVoisin = $xBase - 1;
                break;
            case 4:
                $yVoisin = $yBase + 1;
                if(fmod($yBase,2) == 1) {
                    $xVoisin = $xBase - 1;
                } else {
                    $xVoisin = $xBase;
                }
                break;
            case 5:
                $yVoisin = $yBase + 1;
                if(fmod($yBase,2) == 1) {
                    $xVoisin = $xBase;
                } else {
                    $xVoisin = $xBase + 1;
                }
                break;
            default:
                $xVoisin=$xBase;
                $yVoisin=$yBase;
        }
        return array($xVoisin, $yVoisin);
    }


}