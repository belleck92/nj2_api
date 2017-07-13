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
        $total = 0;
        if($this->line0->riverCanFlow()) $total++;
        if($this->line1->riverCanFlow()) $total++;
        if($this->line2->riverCanFlow()) $total++;
        return $this->has3Lines() && $total == 1;
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


}