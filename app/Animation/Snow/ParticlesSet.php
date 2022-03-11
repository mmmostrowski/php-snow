<?php


namespace TechBit\Snow\Animation\Snow;


class ParticlesSet
{
    const SHAPE = 0;
    const X = 1;
    const Y = 2;
    const MOMENTUM_X = 3;
    const MOMENTUM_Y = 4;

    /**
     * @var array[]
     */
    protected $particles = [];

    /**
     * @var int
     */
    protected $iterator = 0;


    public function addNew(array $data)
    {
        $this->particles[$this->iterator] = $data + [];
        return $this->iterator++;
    }

    /**
     * @return array[]
     */
    public function all()
    {
        return $this->particles;
    }

    /**
     * @return int[]
     */
    public function allIndexes()
    {
        return array_keys($this->particles);
    }


    /**
     * @return int
     */
    public function count()
    {
        return count($this->particles);
    }

    /**
     * @return float
     */
    public function x($idx)
    {
        return $this->particles[$idx][self::X];
    }

    /**
     * @return float
     */
    public function y($idx)
    {
        return $this->particles[$idx][self::Y];
    }

    /**
     * @return string
     */
    public function shape($idx)
    {
        return $this->particles[$idx][self::SHAPE];
    }

    public function moveTo($idx, $x, $y)
    {
        $this->particles[$idx][self::X] = $x;
        $this->particles[$idx][self::Y] = $y;
    }

    public function moveBy($idx, $dX, $dY)
    {
        $this->particles[$idx][self::X] += $dX;
        $this->particles[$idx][self::Y] += $dY;
    }

    public function moveByX($idx, $dx)
    {
        $this->particles[$idx][self::X] += $dx;
    }

    public function moveByY($idx, $dy)
    {
        $this->particles[$idx][self::Y] += $dy;
    }

    public function remove($idx)
    {
        unset($this->particles[$idx]);
    }

    public function moveByArr($idx, $delta)
    {
        $this->particles[$idx][self::X] += $delta[0];
        $this->particles[$idx][self::Y] += $delta[1];
    }

    public function updateMomentum($idx, $dx, $dy)
    {
        $this->particles[$idx][self::MOMENTUM_X] += $dx;
        $this->particles[$idx][self::MOMENTUM_Y] += $dy;
    }

    public function updateMomentumArr($idx, $data)
    {
        $this->particles[$idx][self::MOMENTUM_X] += $data[0];
        $this->particles[$idx][self::MOMENTUM_Y] += $data[1];
    }

    public function moveByMomentum($idx)
    {
        $this->particles[$idx][self::X] += $this->particles[$idx][self::MOMENTUM_X];
        $this->particles[$idx][self::Y] += $this->particles[$idx][self::MOMENTUM_Y];
    }


}