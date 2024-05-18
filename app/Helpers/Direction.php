<?php
namespace App\Helpers;

class Direction
{
    private int $direction;
    private int $directionNumber;

    public function __construct(int $direction = 0, int $directionNumber = 8)
    {
        $this->direction = $direction;
        $this->directionNumber = $directionNumber;
    }
    public function getDirection(): int
    {
        return $this->direction;
    }
    public function getDirectionNumber(): int
    {
        return $this->directionNumber;
    }
    public function next(int $angularVelocity): static
    {
        $this->direction = ($this->direction + $angularVelocity) % $this->directionNumber;
        return $this;
    }
}