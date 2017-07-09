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

class GermeForet
{
    /**
     * @var Hexa
     */
    private $hexaCentral;

    /**
     * @var int
     */
    private $densite;

    /**
     * @var int
     */
    private $coefGauss;

    /**
     * Germe constructor.
     * @param Hexa $hexa
     * @param int $densite
     * @param int $coefGauss
     */
    public function __construct(Hexa $hexa, $densite, $coefGauss)
    {
        $this->hexaCentral = $hexa;
        $this->densite = $densite;
        $this->coefGauss = $coefGauss;
    }

    /**
     * Génère la forêt à partir du germe
     */
    public function generer()
    {
        $this->getHexaCentral()->setVegetation($this->getDensite());
        for($rayon = 1;$this->getDensiteLegale($rayon)>0.4;$rayon++) {
            $couronne = $this->getHexaCentral()->getCouronne($rayon);
            $baisseLegale = $this->getDensiteLegale($rayon - 1) - $this->getDensiteLegale($rayon);
            // Réglage densites
            foreach($couronne as $hexa) {/** @var Hexa $hexa */
                $moy = $this->densiteMoyenneSansCouronne($hexa,$couronne);
                $densiteMax = $moy;
                if($densiteMax==0) $densiteMax = $this->getDensiteLegale($rayon - 1);
                if($hexa->getVegetation() > 0) $densiteMax = max($densiteMax, $hexa->getVegetation());
                $altMin = $densiteMax - $baisseLegale;
                $hexa->setVegetation(mt_rand(round($altMin*1000),round($densiteMax*1000)) / 1000);
            }
        }
    }

    /**
     * Renvoie la densité moyenne des voisins, sans les hexas de la couronne et sans les hexas d'altitude 0
     * @param Hexa $hexa
     * @param HexaCollection $couronne
     * @return float
     */
    public function densiteMoyenneSansCouronne(Hexa $hexa, HexaCollection $couronne)
    {
        $densites = array();
        for($angle=0;$angle<=5;$angle++) {
            $voisin = $hexa->getVoisin($angle);
            if(!is_null($voisin) && !$couronne->exists($voisin) && $voisin->getVegetation() > 0) {
                $densites[] = $voisin->getVegetation();
            }
        }
        if(count($densites) == 0) return 0;
        return array_sum($densites) / count($densites);
    }

    /**
     * Renvoie la densite que devrait avoir une case sur une gaussienne régulière
     * @param $rayon
     * @return float
     */
    public function getDensiteLegale($rayon)
    {
        return exp(-1 * (($this->getCoefGauss()/128) * pow($rayon,2))) * $this->getDensite();
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
    public function getDensite()
    {
        return $this->densite;
    }

    /**
     * @param int $densite
     */
    public function setDensite($densite)
    {
        $this->densite = $densite;
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