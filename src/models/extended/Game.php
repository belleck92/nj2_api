<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 2017-07-09
 * Time: 16:40:03
 */

namespace Fr\Nj2\Api\models\extended;

use Exception;
use Fr\Nj2\Api\mapGeneration\Dot;
use Fr\Nj2\Api\mapGeneration\Germe;
use Fr\Nj2\Api\mapGeneration\GermeForet;
use Fr\Nj2\Api\mapGeneration\Line;
use Fr\Nj2\Api\models\business\HexaBusiness;
use Fr\Nj2\Api\models\business\TypeResourceBusiness;
use Fr\Nj2\Api\models\collection\ResourceCollection;
use Fr\Nj2\Api\models\DbHandler;
use Fr\Nj2\Api\models\store\GameStore;
use Fr\Nj2\Api\models\store\HexaStore;

class Game extends \Fr\Nj2\Api\models\Game
{

    /**
     * @var int
     */
    private $nbGermes;

    /**
     * @var int
     */
    private $altMin;

    /**
     * @var int
     */
    private $altMax;

    /**
     * coef entre 0 et 16, 16 veut dire le plus pointu
     * Le coefficient de x sur la fonction gaussienne est $coefGauss/128
     * @var int
     */
    private $coefGaussMinGermes;

    /**
     * @var int
     */
    private $coefGaussMaxGermes;

    /**
     * @var int
     */
    private $randGermes;

    /**
     * @var int
     */
    private $varGermeTemperatureMin;

    /**
     * @var int
     */
    private $varGermeTemperatureMax;

    /**
     * @var int
     */
    private $coefGaussMinTemperature;

    /**
     * @var int
     */
    private $coefGaussMaxTemperature;

    /**
     * @var int
     */
    private $randTemperatures;

    /**
     * @var int
     */
    private $randRivieres;

    /**
     * @var int
     */
    private $nbGermesForet;

    /**
     * @var int
     */
    private $coefGaussMinGermesForet;

    /**
     * @var int
     */
    private $coefGaussMaxGermesForet;

    /**
     * @var int
     */
    private $randForet;

    /**
     * @var int
     */
    private $idHexaMini;

    /**
     * @var ResourceCollection
     */
    private $allResources;

    /**
     * @var Dot[]
     */
    private $dots = [];

    /**
     * @var Line[]
     */
    private $lines = [];

    /**
     * Génère entièrement la carte
     */
    public function genererHexas() {
        GameStore::store($this);
        $this->genererHexasVierges();
        $this->genererGermes();
        $this->cotesEnDentelle();
        $this->erosionMontagnes();
        $this->genererTemperatures();
        $this->creerRivieres();
        $this->genererVegetation();
        $this->genererRessources();

        foreach($this->getHexas() as $hexa) {
            $hexa->save();
        }
    }

    /**
     * Génère la carte entière de cases vierges, océaniques
     */
    public function genererHexasVierges()
    {
        $this->resetCacheHexas();
        $id = $this->getNextId();
        $this->idHexaMini = $id;
        for($y=0;$y<$this->getHeight();$y++) {
            for ($x = 0; $x < $this->getWidth();$x++) {
                $hexa = $this->createHexa();
                $hexa->setX($x);
                $hexa->setY($y);
                $this->getHexas()->ajout($hexa);
                $hexa->save();
            }
        }
        $this->getHexas()->store();
    }

    public function getNextId()
    {
        $req = "SELECT MAX(idHexa) as maxou FROM hexa;";
        $res = DbHandler::query($req);
        $res = mysqli_fetch_assoc($res);
        return $res['maxou'] + 1;
    }

    /**
     * Crée les germes de continents
     */
    public function genererGermes()
    {
        mt_srand($this->getRandGermes());
        $germesIds = array();
        for($i=1;$i<=$this->getNbGermes();$i++) {
            do {
                $id = mt_rand($this->getIdHexaMini(), $this->getIdHexaMini() + ($this->getLargeur() * $this->getHauteur()) - 1);
            } while (in_array($id, $germesIds));
            $germesIds[] = $id;
        }
        foreach($germesIds as $id) {
            $hexa = HexaStore::getById($id);
            $germe = new Germe($hexa,mt_rand($this->getAltMin(), $this->getAltMax()),mt_rand($this->getCoefGaussMinGermes(), $this->getCoefGaussMaxGermes()));
            $germe->generer();
        }
    }

    /**
     * Crée la végétation
     */
    public function genererVegetation()
    {
        // Germes
        mt_srand($this->getRandForet());
        $germesIds = array();
        for($i=1;$i<=$this->getNbGermesForet();$i++) {
            do {
                $id = mt_rand($this->getIdHexaMini(), $this->getIdHexaMini() + ($this->getLargeur() * $this->getHauteur()) - 1);
                $hexa = HexaStore::getById($id);
            } while (in_array($id, $germesIds) && $hexa->getAltitude() < 4);
            $germesIds[] = $id;
        }
        foreach($germesIds as $id) {
            $hexa = HexaStore::getById($id);
            $germe = new GermeForet($hexa,mt_rand(13, 15),mt_rand($this->getCoefGaussMinGermesForet(), $this->getCoefGaussMaxGermesForet()));
            $germe->generer();
        }

        // Supprimer la végétation des mers
        foreach($this->getHexas() as $hexa) {
            if($hexa->getAltitude() < 4) $hexa->setVegetation(0);
        }

        // Adapter la végétation à l'altitude
        foreach($this->getHexas() as $hexa) {
            if($hexa->getAltitude() >=12 ) $hexa->setVegetation(max(0,$hexa->getVegetation()-4));
        }

        // Influence des rivières sur la végétation
        /*foreach($this->getHexas() as $hexa) {/** @var Hexa $hexa */
            /*if($hexa->getRivieres()->count() > 0) {
                $hexa->setVegetation(min(15,$hexa->getVegetation() + 1.5));
            }
        }*/
    }

    /**
     * Découpe un peu les côtes pour les rendres moins hexagonales
     */
    public function cotesEnDentelle() {
        foreach($this->getHexas() as $hexa) {
            if($hexa->getAltitude() >= 4) {
                $cptMers = 0;
                foreach($hexa->getCouronne(1) as $voisin) {
                    if($voisin->getAltitude() < 4) $cptMers++;
                }
                if($cptMers >= 2 && mt_rand(1,2)==2) $hexa->setAltitude(0);
            }
        }
    }

    /**
     * Érode les montagnes et les collines
     * @return void
     */
    public function erosionMontagnes()
    {
        foreach($this->getHexas() as $hexa) {/** @var Hexa $hexa */
            if($hexa->getAltitude() >= 8) {
                if(mt_rand(1,4) == 4) $hexa->setAltitude($hexa->getAltitude()-3);
            }
        }
    }

    /**
     * Génère les températures des cases en fonction de l'altitude et de la latitude
     * Ajoute les climats océaniques et les micro climats
     * Températures entre 0 et 15 pour l'instant, elles seront lissées plus tard
     */
    public function genererTemperatures()
    {
        mt_srand($this->getRandTemperatures());
        foreach($this->getHexas() as $hexa) {
            // Latitude
            $latitude = min($hexa->getY(), $this->getYMax()-$hexa->getY())/($this->getHauteur()/2);
            $hexa->setTemperature((400*pow(($latitude-0.5),5)) + 8.5);

            // Altitude
            $varAltitude = max($hexa->getAltitude()-4,0)*(5/8);
            $hexa->setTemperature(min($hexa->getTemperature()-$varAltitude,15));
        }

        // Climats océaniques
        foreach($this->getHexas() as $hexa) {
            if($hexa->getAltitude() < 4) {
                $ecart = $hexa->getTemperature() - 7.5;
                $hexa->setTemperature($hexa->getTemperature() - ($ecart/3));
            }
        }

        // Climats des littoraux
        foreach($this->getHexas() as $hexa) {
            if($hexa->getAltitude() >= 4) {
                foreach($hexa->getCouronne(1) as $voisin) {
                    if($voisin->getAltitude() < 4) {
                        $ecart = $hexa->getTemperature() - 7.5;
                        $hexa->setTemperature($hexa->getTemperature() - ($ecart/3));
                        break;
                    }
                }
            }
        }

        // Micro climats
        foreach($this->getHexas() as $hexa) {/** @var Hexa $hexa */
            if(mt_rand(1,10) == 1) {
                $hexa->setTemperature(max(min($hexa->getTemperature() + (mt_rand(1,2)*2) - 3,15),0));
            }
        }
    }

    /**
     * Crée les rivieres de la carte
     */
    public function creerRivieres()
    {
        foreach($this->getHexas() as $hexa) {

            /*
             * Dots creation
             */
            if(!isset($hexa->dots[0])) {
                $dot = new Dot();
                if(!is_null($hexa->getVoisin(1))) {
                    $hexa->getVoisin(1)->dots[3] = $dot;
                }
                $hexa->dots[0] = $dot;
                $hexa->getVoisin(0)->dots[2] = $dot;
                $this->dots[] = $dot;
            }
            if(!isset($hexa->dots[1]) && !is_null($hexa->getVoisin(1)) && !is_null($hexa->getVoisin(2))) {
                $dot = new Dot();
                $hexa->dots[1] = $dot;
                $hexa->getVoisin(1)->dots[3] = $dot;
                $hexa->getVoisin(2)->dots[5] = $dot;
                $this->dots[] = $dot;
            }
            if(!isset($hexa->dots[2])) {
                $dot = new Dot();
                $hexa->dots[2] = $dot;
                $hexa->getVoisin(2)->dots[4] = $dot;
                $hexa->getVoisin(3)->dots[0] = $dot;
                $this->dots[] = $dot;
            }
            if(!isset($hexa->dots[3])) {
                $dot = new Dot();
                $hexa->dots[3] = $dot;
                $hexa->getVoisin(3)->dots[5] = $dot;
                if(!is_null($hexa->getVoisin(4))) {
                    $hexa->getVoisin(4)->dots[1] = $dot;
                }
                $this->dots[] = $dot;
            }
            if(!isset($hexa->dots[4]) && !is_null($hexa->getVoisin(4)) && !is_null($hexa->getVoisin(5))) {
                $dot = new Dot();
                $hexa->dots[4] = $dot;
                $hexa->getVoisin(4)->dots[0] = $dot;
                $hexa->getVoisin(5)->dots[2] = $dot;
                $this->dots[] = $dot;
            }
            if(!isset($hexa->dots[5])) {
                $dot = new Dot();
                $hexa->dots[5] = $dot;
                $hexa->getVoisin(0)->dots[3] = $dot;
                if(!is_null($hexa->getVoisin(5))) {
                    $hexa->getVoisin(5)->dots[1] = $dot;
                }
                $this->dots[] = $dot;
            }

            /*
             * Lines creation
             */
            if(!isset($hexa->lines[0])) {
                $line = new Line();
                $hexa->lines[0] = $line;
                $hexa->getVoisin(0)->lines[3] = $line;
                $line->setDot0($hexa->dots[0]);
                $line->setDot1($hexa->dots[5]);
                $line->setHexa0($hexa->getVoisin(0));
                $line->setHexa1($hexa);
                $this->lines[] = $line;
                $hexa->dots[0]->setLine2($line);
                $hexa->dots[5]->setLine0($line);
            }
            if(!isset($hexa->lines[1]) && !is_null($hexa->getVoisin(1))) {
                $line = new Line();
                $hexa->lines[1] = $line;
                if(!is_null($hexa->getVoisin(1))) $hexa->getVoisin(1)->lines[4] = $line;
                $line->setDot0($hexa->dots[1]);
                $line->setDot1($hexa->dots[0]);
                if(!is_null($hexa->getVoisin(1))) $line->setHexa0($hexa->getVoisin(1));
                $line->setHexa1($hexa);
                $this->lines[] = $line;
                $hexa->dots[0]->setLine1($line);
                $hexa->dots[1]->setLine2($line);
            }
            if(!isset($hexa->lines[2]) && !is_null($hexa->getVoisin(2))) {
                $line = new Line();
                $hexa->lines[2] = $line;
                if(!is_null($hexa->getVoisin(2))) $hexa->getVoisin(2)->lines[5] = $line;
                $line->setDot0($hexa->dots[1]);
                $line->setDot1($hexa->dots[2]);
                if(!is_null($hexa->getVoisin(2))) $line->setHexa0($hexa->getVoisin(2));
                $line->setHexa1($hexa);
                $this->lines[] = $line;
                $hexa->dots[1]->setLine1($line);
                $hexa->dots[2]->setLine0($line);
            }
            if(!isset($hexa->lines[3])) {
                $line = new Line();
                $hexa->lines[3] = $line;
                $hexa->getVoisin(3)->lines[0] = $line;
                $line->setDot0($hexa->dots[2]);
                $line->setDot1($hexa->dots[3]);
                $line->setHexa0($hexa);
                $line->setHexa1($hexa->getVoisin(3));
                $this->lines[] = $line;
                $hexa->dots[2]->setLine2($line);
                $hexa->dots[3]->setLine0($line);
            }
            if(!isset($hexa->lines[4]) && !is_null($hexa->getVoisin(4))) {
                $line = new Line();
                $hexa->lines[4] = $line;
                if(!is_null($hexa->getVoisin(4))) $hexa->getVoisin(4)->lines[1] = $line;
                $line->setDot0($hexa->dots[3]);
                $line->setDot1($hexa->dots[4]);
                if(!is_null($hexa->getVoisin(4))) $line->setHexa0($hexa->getVoisin(4));
                $line->setHexa1($hexa);
                $this->lines[] = $line;
                $hexa->dots[3]->setLine2($line);
                $hexa->dots[4]->setLine1($line);
            }
            if(!isset($hexa->lines[5]) && !is_null($hexa->getVoisin(5))) {
                $line = new Line();
                $hexa->lines[5] = $line;
                if(!is_null($hexa->getVoisin(5))) $hexa->getVoisin(5)->lines[2] = $line;
                $line->setDot0($hexa->dots[5]);
                $line->setDot1($hexa->dots[4]);
                if(!is_null($hexa->getVoisin(5))) $line->setHexa0($hexa->getVoisin(5));
                $line->setHexa1($hexa);
                $this->lines[] = $line;
                $hexa->dots[4]->setLine0($line);
                $hexa->dots[5]->setLine1($line);
            }
        }

        /*
         * Get beginning of rivers
         */
        $beginingCandidates = [];
        foreach($this->dots as $index=>$dot) {
            if(is_null($dot)) echo $index."\n";
        }
        foreach ($this->dots as $dot) {
            if($dot->canBeginRiver()) $beginingCandidates[] = $dot;
        }
        if(!count($beginingCandidates)) throw new Exception("No dots candidates to begin a river");
        $indexes = array_rand($beginingCandidates, max(round(count($beginingCandidates)/10), 1));
        $beginningDots = array_intersect_key($beginingCandidates, array_flip($indexes));
        
        /*
         * Trace main rivers
         */
        foreach ($beginningDots as $beginningDot) {/** @var Dot $beginningDot */
            $beginningDot->traceRiver();
        }

        /*
         * Save data
         */
        foreach ($this->lines as $line) {
            if($line->isRiver()) {
                $ford = rand(1,100) < Parameter::getByFctId(Parameter::PROBA_FORD)->getValue();
                $river = $line->getHexa0()->createRiver();
                $river->setSide($line->getHexa0()->quelVoisin($line->getHexa1()));
                $river->setFord($ford);
                $river->save();
                $river = $line->getHexa1()->createRiver();
                $river->setSide($line->getHexa1()->quelVoisin($line->getHexa0()));
                $river->setFord($ford);
                $river->save();
            }
            echo $line."\n";
        }
        
    }

    /**
     * @param Hexa $hexa1
     * @param Hexa $hexa2
     * @return string
     */
    public static function getIndexCouple(Hexa $hexa1, Hexa $hexa2){
        return min($hexa1->getId(),$hexa2->getId()).'_'.max($hexa1->getId(),$hexa2->getId());
    }

    /**
     * Génère les ressources sur la carte
     */
    public function genererRessources()
    {
        $this->allResources = new ResourceCollection();
        TypeResourceBusiness::getAll()->store();
        foreach($this->getHexas() as $hexa) {
            $typeResource = $hexa->getTypeClimate()->determineRandomResource();
            if(!is_null($typeResource)) {
                $res = $hexa->createResource();
                $res->setIdTypeResource($typeResource->getId());
                $res->save();
            }
        }
    }

    /**
     * Charge les valeurs nécessaires au générateur à partir du seed
     */
    public function loadValeursGenerateur() {
        $this->setNbGermes(hexdec(substr($this->getSeed(),0,2)));
        $this->setAltMin(hexdec(substr($this->getSeed(),2,1)));
        $this->setAltMax(hexdec(substr($this->getSeed(),3,1)));
        $this->setCoefGaussMinGermes(hexdec(substr($this->getSeed(),4,1)));
        $this->setCoefGaussMaxGermes(hexdec(substr($this->getSeed(),5,1)));
        $this->setRandGermes(hexdec(substr($this->getSeed(),6,5)));
        $this->setRandTemperatures(hexdec(substr($this->getSeed(),11,5)));
        $this->setRandRivieres(hexdec(substr($this->getSeed(),16,5)));
        $this->setNbGermesForet(hexdec(substr($this->getSeed(),21,2)));
        $this->setCoefGaussMinGermesForet(hexdec(substr($this->getSeed(),22,1)));
        $this->setCoefGaussMaxGermesForet(hexdec(substr($this->getSeed(),23,1)));
        $this->setRandForet(hexdec(substr($this->getSeed(),24,5)));
    }

    /**
     * Trouve la valeur du seed par rapport aux valeurs de la partie
     */
    public function setSeedFromValues()
    {
        $this->setSeed(
            str_pad(dechex($this->getNbGermes()),2,'0',STR_PAD_LEFT).
            str_pad(dechex($this->getAltMin()),1,'0',STR_PAD_LEFT).
            str_pad(dechex($this->getAltMax()),1,'0',STR_PAD_LEFT).
            str_pad(dechex($this->getCoefGaussMinGermes()),1,'0',STR_PAD_LEFT).
            str_pad(dechex($this->getCoefGaussMaxGermes()),1,'0',STR_PAD_LEFT).
            str_pad(dechex($this->getRandGermes()),5,'0',STR_PAD_LEFT).
            str_pad(dechex($this->getRandTemperatures()),5,'0',STR_PAD_LEFT).
            str_pad(dechex($this->getRandRivieres()),5,'0',STR_PAD_LEFT).
            str_pad(dechex($this->getNbGermesForet()),2,'0',STR_PAD_LEFT).
            str_pad(dechex($this->getCoefGaussMinGermesForet()),1,'0',STR_PAD_LEFT).
            str_pad(dechex($this->getCoefGaussMaxGermesForet()),1,'0',STR_PAD_LEFT).
            str_pad(dechex($this->getRandForet()),5,'0',STR_PAD_LEFT)
        );
    }

    /**
     * @return int
     */
    public function getNbGermes()
    {
        return $this->nbGermes;
    }

    /**
     * @param int $nbGermes
     */
    public function setNbGermes($nbGermes)
    {
        $this->nbGermes = $nbGermes;
    }

    /**
     * @return int
     */
    public function getAltMin()
    {
        return $this->altMin;
    }

    /**
     * @param int $altMin
     */
    public function setAltMin($altMin)
    {
        $this->altMin = $altMin;
    }

    /**
     * @return int
     */
    public function getAltMax()
    {
        return $this->altMax;
    }

    /**
     * @param int $altMax
     */
    public function setAltMax($altMax)
    {
        $this->altMax = $altMax;
    }

    /**
     * @return int
     */
    public function getCoefGaussMinGermes()
    {
        return $this->coefGaussMinGermes;
    }

    /**
     * @param int $coefGaussMinGermes
     */
    public function setCoefGaussMinGermes($coefGaussMinGermes)
    {
        $this->coefGaussMinGermes = $coefGaussMinGermes;
    }

    /**
     * @return int
     */
    public function getCoefGaussMaxGermes()
    {
        return $this->coefGaussMaxGermes;
    }

    /**
     * @param int $coefGaussMaxGermes
     */
    public function setCoefGaussMaxGermes($coefGaussMaxGermes)
    {
        $this->coefGaussMaxGermes = $coefGaussMaxGermes;
    }

    /**
     * @return int
     */
    public function getRandGermes()
    {
        return $this->randGermes;
    }

    /**
     * @param int $randGermes
     */
    public function setRandGermes($randGermes)
    {
        $this->randGermes = $randGermes;
    }

    /**
     * @return int
     */
    public function getVarGermeTemperatureMin()
    {
        return $this->varGermeTemperatureMin;
    }

    /**
     * @param int $varGermeTemperatureMin
     */
    public function setVarGermeTemperatureMin($varGermeTemperatureMin)
    {
        $this->varGermeTemperatureMin = $varGermeTemperatureMin;
    }

    /**
     * @return int
     */
    public function getVarGermeTemperatureMax()
    {
        return $this->varGermeTemperatureMax;
    }

    /**
     * @param int $varGermeTemperatureMax
     */
    public function setVarGermeTemperatureMax($varGermeTemperatureMax)
    {
        $this->varGermeTemperatureMax = $varGermeTemperatureMax;
    }

    /**
     * @return int
     */
    public function getCoefGaussMinTemperature()
    {
        return $this->coefGaussMinTemperature;
    }

    /**
     * @param int $coefGaussMinTemperature
     */
    public function setCoefGaussMinTemperature($coefGaussMinTemperature)
    {
        $this->coefGaussMinTemperature = $coefGaussMinTemperature;
    }

    /**
     * @return int
     */
    public function getCoefGaussMaxTemperature()
    {
        return $this->coefGaussMaxTemperature;
    }

    /**
     * @param int $coefGaussMaxTemperature
     */
    public function setCoefGaussMaxTemperature($coefGaussMaxTemperature)
    {
        $this->coefGaussMaxTemperature = $coefGaussMaxTemperature;
    }

    /**
     * @return int
     */
    public function getRandTemperatures()
    {
        return $this->randTemperatures;
    }

    /**
     * @param int $randTemperatures
     */
    public function setRandTemperatures($randTemperatures)
    {
        $this->randTemperatures = $randTemperatures;
    }

    /**
     * @return int
     */
    public function getRandRivieres()
    {
        return $this->randRivieres;
    }

    /**
     * @param int $randRivieres
     */
    public function setRandRivieres($randRivieres)
    {
        $this->randRivieres = $randRivieres;
    }

    /**
     * @return int
     */
    public function getNbGermesForet()
    {
        return $this->nbGermesForet;
    }

    /**
     * @param int $nbGermesForet
     */
    public function setNbGermesForet($nbGermesForet)
    {
        $this->nbGermesForet = $nbGermesForet;
    }

    /**
     * @return int
     */
    public function getCoefGaussMinGermesForet()
    {
        return $this->coefGaussMinGermesForet;
    }

    /**
     * @param int $coefGaussMinGermesForet
     */
    public function setCoefGaussMinGermesForet($coefGaussMinGermesForet)
    {
        $this->coefGaussMinGermesForet = $coefGaussMinGermesForet;
    }

    /**
     * @return int
     */
    public function getCoefGaussMaxGermesForet()
    {
        return $this->coefGaussMaxGermesForet;
    }

    /**
     * @param int $coefGaussMaxGermesForet
     */
    public function setCoefGaussMaxGermesForet($coefGaussMaxGermesForet)
    {
        $this->coefGaussMaxGermesForet = $coefGaussMaxGermesForet;
    }

    /**
     * @return int
     */
    public function getRandForet()
    {
        return $this->randForet;
    }

    /**
     * @param int $randForet
     */
    public function setRandForet($randForet)
    {
        $this->randForet = $randForet;
    }

    /**
     * @return int
     */
    public function getLargeur()
    {
        return $this->getWidth();
    }

    /**
     * @return int
     */
    public function getHauteur()
    {
        return $this->getHeight();
    }

    /**
     * @return int
     */
    public function getIdHexaMini()
    {
        if(is_null($this->idHexaMini)) {
            $req = "SELECT MIN(idHexa) as mini FROM hexa WHERE idGame=".$this->getId();
            $res = DbHandler::query($req);
            $res = mysqli_fetch_assoc($res);
            $this->idHexaMini = $res['mini'];
        }
        return $this->idHexaMini;
    }

    /**
     * Renvoie un hexa à partir de ses coordonnées
     * @param int $x
     * @param int $y
     * @return Hexa
     */
    public function getHexaByCoords($x, $y)
    {
        $coords = $this->coordsCorrigees($x,$y);
        if(is_null($coords)) return null;
        return HexaStore::getById($this->getIdHexaMini() + $coords[0] + ($coords[1]*$this->getLargeur()));
    }

    /**
     * Corrige les coordonnées fournies si en dehors de la carte. Renvoie null si la case n'existe pas
     * @param int $x
     * @param int $y
     * @return array 0:x 1:y
     */
    public function coordsCorrigees($x,$y){
        while($x<0) $x+=$this->getLargeur();
        while($x>$this->getXMax()) $x-=$this->getLargeur();
        if($y<0 || $y>$this->getYMax()) return null;
        return array($x,$y);
    }

    /**
     * Renvoie le X maximum des cases de la partie
     * @return int
     */
    public function getXMax()
    {
        return $this->getLargeur()-1;
    }

    /**
     * Renvoie le X maximum des cases de la partie
     * @return int
     */
    public function getYMax()
    {
        return $this->getHauteur()-1;
    }
}