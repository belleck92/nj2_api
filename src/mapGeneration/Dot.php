<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 12/07/17
 * Time: 13:33
 */

namespace Fr\Nj2\Api\mapGeneration;

class Dot
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var Line
     */
    private $line0;

    /**
     * @var Line
     */
    private $line1;

    /**
     * @var Line
     */
    private $line2;

    /**
     * Line constructor.
     */
    public function __construct()
    {
        $this->id = md5(rand(1,1000000).microtime(true));
    }

    /**
     * @return float
     */
    public function getHeight()
    {
        $nblines = 0;
        $totalHeight = 0;
        if(!is_null($this->line0)) {
            $nblines++;
            $totalHeight += $this->line0->getHeight();
        }
        if(!is_null($this->line1)) {
            $nblines++;
            $totalHeight += $this->line1->getHeight();
        }
        if(!is_null($this->line2)) {
            $nblines++;
            $totalHeight += $this->line2->getHeight();
        }
        return $totalHeight / $nblines;
    }

    /**
     * Returns the dot at the end of the line
     * @param Line $line
     * @return Dot
     */
    public function connectedDot(Line $line)
    {
        if($line->getDot0()->getId() == $this->id) return $line->getDot1();
        else return $line->getDot0();
    }

    /**
     * Returns the higher connected dot of the dot
     * @return Dot
     */
    public function higherConnectedDot()
    {
        $ret = null;/** @var Dot $ret */
        if(!is_null($this->line0)) {
            if(is_null($ret) || $this->connectedDot($this->line0)->getHeight() > $ret->getHeight()) $ret = $this->connectedDot($this->line0);
        }
        if(!is_null($this->line1)) {
            if(is_null($ret) || $this->connectedDot($this->line1)->getHeight() > $ret->getHeight()) $ret = $this->connectedDot($this->line1);
        }
        if(!is_null($this->line2)) {
            if(is_null($ret) || $this->connectedDot($this->line2)->getHeight() > $ret->getHeight()) $ret = $this->connectedDot($this->line2);
        }
        return $ret;
    }

    /**
     * @return bool
     */
    public function has3Lines()
    {
        return !is_null($this->line0) && !is_null($this->line1) && !is_null($this->line2);
    }

    /**
     * Tells if the dot is at a coastline and has a line in land
     * @return true
     */
    public function canBeginRiver()
    {
        if(!$this->has3Lines()) return false;
        $total = 0;
        if($this->line0->riverCanFlow()) $total++;
        if($this->line1->riverCanFlow()) $total++;
        if($this->line2->riverCanFlow()) $total++;
        return $total == 1;
    }

    /**
     * Traces a river from this dot
     */
    public function traceRiver()
    {
        $trace = true;
        $line = null;
        if($this->line0->riverCanFlow()) $line = $this->line0;
        if($this->line1->riverCanFlow()) $line = $this->line1;
        if($this->line2->riverCanFlow()) $line = $this->line2;
        $dot = $this;
        $line->setRiver(true);
        $dot = $dot->connectedDot($line);

        while($trace) {
            $height = 0;
            $nextLine = null;
            if (!is_null($dot->getLine0()) && $dot->getLine0()->getId() != $line->getId() && $height <= $dot->getLine0()->getHeight() && !$dot->connectedDot($dot->getLine0())->hasRiver() && !$dot->connectedDot($dot->getLine0())->canBeginRiver()) {
                $nextLine = $dot->getLine0();
                $height = $nextLine->getHeight();
            }
            if (!is_null($dot->getLine1()) && $dot->getLine1()->getId() != $line->getId() && $height <= $dot->getLine1()->getHeight() && !$dot->connectedDot($dot->getLine1())->hasRiver() && !$dot->connectedDot($dot->getLine1())->canBeginRiver()) {
                $nextLine = $dot->getLine1();
                $height = $nextLine->getHeight();
            }
            if (!is_null($dot->getLine2()) && $dot->getLine2()->getId() != $line->getId() && $height <= $dot->getLine2()->getHeight() && !$dot->connectedDot($dot->getLine2())->hasRiver() && !$dot->connectedDot($dot->getLine2())->canBeginRiver()) {
                $nextLine = $dot->getLine2();
            }
            if (is_null($nextLine)) break;
            $dot = $dot->connectedDot($nextLine);
            $line = $nextLine;
            $line->setRiver(true);
        }

    }

    /**
     * @return bool
     */
    public function hasRiver()
    {
        if(!is_null($this->line0) && $this->line0->isRiver()) return true;
        if(!is_null($this->line1) && $this->line1->isRiver()) return true;
        if(!is_null($this->line2) && $this->line2->isRiver()) return true;
        return false;
    }

    /**
     * @return Line
     */
    public function getLine0()
    {
        return $this->line0;
    }

    /**
     * @param Line $line0
     */
    public function setLine0($line0)
    {
        $this->line0 = $line0;
    }

    /**
     * @return Line
     */
    public function getLine1()
    {
        return $this->line1;
    }

    /**
     * @param Line $line1
     */
    public function setLine1($line1)
    {
        $this->line1 = $line1;
    }

    /**
     * @return Line
     */
    public function getLine2()
    {
        return $this->line2;
    }

    /**
     * @param Line $line2
     */
    public function setLine2($line2)
    {
        $this->line2 = $line2;
    }

    function __toString()
    {
        $ret = '';
        if(!is_null($this->line0)) {
            if($ret) $ret .='|';
            $ret .= 'L0 '.$this->line0;
        }
        if(!is_null($this->line1)) {
            if($ret) $ret .='|';
            $ret .= 'L1 '.$this->line1;
        }
        if(!is_null($this->line2)) {
            if($ret) $ret .='|';
            $ret .= 'L2 '.$this->line2;
        }
        return $ret.' ';
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}