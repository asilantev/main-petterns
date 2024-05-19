<?php

namespace App\Fuel;

use App\Exceptions\CommandException;
use App\Interfaces\CommandInterface;
use App\Interfaces\FuelableInterface;

class CheckFuelCommand implements CommandInterface
{
    public function __construct(private FuelableInterface $fuelable)
    {
    }

    public function execute(): void
    {
        if ($this->fuelable->getFuel() < $this->fuelable->getSpendVelocity()) {
            throw new CommandException('Недостаточно топлива');
        }
    }
}