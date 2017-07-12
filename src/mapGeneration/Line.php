<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 12/07/17
 * Time: 13:33
 */

namespace Fr\Nj2\Api\mapGeneration;


use Fr\Nj2\Api\models\extended\Hexa;

class Line
{
    /**
     * @var Hexa
     */
    private $hexa0;

    /**
     * @var Hexa
     */
    private $hexa1;

    /**
     * @var Dot
     */
    private $dot0;

    /**
     * @var Dot
     */
    private $dot1;

    /**
     * @return float
     */
    public function getHeight()
    {
        $nbHexas = 0;
        $totalHeight = 0;
        if(!is_null($this->hexa0)) {
            $nbHexas++;
            $totalHeight += $this->hexa0->getAltitude();
        }
        if(!is_null($this->hexa1)) {
            $nbHexas++;
            $totalHeight += $this->hexa1->getAltitude();
        }
        return $totalHeight / $nbHexas;
    }

    /**
     * @return bool
     */
    public function riverCanFlow()
    {
        return (!is_null($this->hexa0) && !is_null($this->hexa1)) &&
        ($this->hexa0->getAltitude() >= 4 && $this->hexa1->getAltitude() >= 4);
    }

    /**
     * @return Hexa
     */
    public function getHexa0()
    {
        return $this->hexa0;
    }

    /**
     * @param Hexa $hexa0
     */
    public function setHexa0($hexa0)
    {
        $this->hexa0 = $hexa0;
    }

    /**
     * @return Hexa
     */
    public function getHexa1()
    {
        return $this->hexa1;
    }

    /**
     * @param Hexa $hexa1
     */
    public function setHexa1($hexa1)
    {
        $this->hexa1 = $hexa1;
    }

    /**
     * @return Dot
     */
    public function getDot0()
    {
        return $this->dot0;
    }

    /**
     * @param Dot $dot0
     */
    public function setDot0($dot0)
    {
        $this->dot0 = $dot0;
    }

    /**
     * @return Dot
     */
    public function getDot1()
    {
        return $this->dot1;
    }

    /**
     * @param Dot $dot1
     */
    public function setDot1($dot1)
    {
        $this->dot1 = $dot1;
    }

    function __toString()
    {
        $ret = '';
        if(!is_null($this->hexa0)) {
            if($ret) $ret .= ',';
            $ret .= 'h0:'.$this->hexa0->getId();
        }
        if(!is_null($this->hexa1)) {
            if($ret) $ret .= ',';
            $ret .= 'h1:'.$this->hexa1->getId();
        }
        return $ret;
    }


}