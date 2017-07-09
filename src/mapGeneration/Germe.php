<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 08/08/15
 * Time: 20:29
 */

namespace Fr\Nj2\Api\mapGeneration;

use Fr\Nj2\Api\models\collection\HexaCollection;
use Fr\Nj2\Api\models\extended\Hexa;

class Germe
{
    /**
     * @var Hexa
     */
    private $hexaCentral;

    /**
     * @var int
     */
    private $altitude;

    /**
     * @var int
     */
    private $coefGauss;

    /**
     * Germe constructor.
     * @param Hexa $hexa
     * @param int $altitude
     * @param int $coefGauss
     */
    public function __construct(Hexa $hexa, $altitude, $coefGauss)
    {
        $this->hexaCentral = $hexa;
        $this->altitude = $altitude;
        $this->coefGauss = $coefGauss;
    }

    /**
     * Génère l'île à partir du germe
     */
    public function generer()
    {
        $this->getHexaCentral()->setAltitude($this->getAltitude());
        for($rayon = 1;$this->getHauteurLegale($rayon)>0.4;$rayon++) {
            $couronne = $this->getHexaCentral()->getCouronne($rayon);
            $baisseLegale = $this->getHauteurLegale($rayon - 1) - $this->getHauteurLegale($rayon);
            // Réglage altitudes
            foreach($couronne as $hexa) {/** @var Hexa $hexa */
                $moy = $this->altitudeMoyenneSansCouronne($hexa,$couronne);
                $altMax = $moy;
                if($altMax==0) $altMax = $this->getHauteurLegale($rayon - 1);
                if($hexa->getAltitude() > 0) $altMax = max($altMax, $hexa->getAltitude());
                $altMin = $altMax - $baisseLegale;
                $hexa->setAltitude(mt_rand(round($altMin*1000),round($altMax*1000)) / 1000);
            }
        }
    }

    /**
     * Renvoie l'altitude moyenne des voisins, sans les hexas de la couronne et sans les hexas d'altitude 0
     * @param Hexa $hexa
     * @param HexaCollection $couronne
     * @return float
     */
    public function altitudeMoyenneSansCouronne(Hexa $hexa, HexaCollection $couronne)
    {
        $altitudes = array();
        for($angle=0;$angle<=5;$angle++) {
            $voisin = $hexa->getVoisin($angle);
            if(!is_null($voisin) && !$couronne->exists($voisin) && $voisin->getAltitude() > 0) {
                $altitudes[] = $voisin->getAltitude();
            }
        }
        if(count($altitudes) == 0) return 0;
        return array_sum($altitudes) / count($altitudes);
    }

    /**
     * Renvoie la hauteur que devrait avoir une case sur une gaussienne régulière
     * @param $rayon
     * @return float
     */
    public function getHauteurLegale($rayon)
    {
        return exp(-1 * (($this->getCoefGauss()/128) * pow($rayon,2))) * $this->getAltitude();
    }

    /**
     * @return Hexa
     */
    public function getHexaCentral()
    {
        return $this->hexaCentral;
    }

    /**
     * @param Hexa $hexa
     */
    public function setHexaCentral($hexa)
    {
        $this->hexaCentral = $hexa;
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
     * @return int
     */
    public function getCoefGauss()
    {
        return $this->coefGauss;
    }

    /**
     * @param int $coefGauss
     */
    public function setCoefGauss($coefGauss)
    {
        $this->coefGauss = $coefGauss;
    }

}