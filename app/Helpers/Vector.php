<?php
namespace App\Helpers;

class Vector
{
    private float $x;
    private float $y;

    public function __construct(float $x, float $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public static function plus(Vector $v1, Vector $v2): static
    {
        return $v1
            ->setX($v1->getX() + $v2->getX())
            ->setY($v1->getY() + $v2->getY());
    }

    public function setX(float $x): static
    {
        $this->x = $x;
        return $this;
    }

    /**
     * @return float
     */
    public function getX(): float
    {
        return $this->x;
    }
    public function setY(float $y): static
    {
        $this->y = $y;
        return $this;
    }

    /**
     * @return float
     */
    public function getY(): float
    {
        return $this->y;
    }

}