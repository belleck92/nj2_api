<?php
/**
 * Created by IntelliJ IDEA.
 * User: manu
 * Date: 09/07/17
 * Time: 11:25
 */

namespace Fr\Nj2\Api\mapGeneration;


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


}