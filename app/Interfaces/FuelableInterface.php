<?php

namespace App\Interfaces;

interface FuelableInterface
{
    public function getFuel(): int;
    public function setFuel(int $fuel): void;
    public function getSpendVelocity(): int;
}