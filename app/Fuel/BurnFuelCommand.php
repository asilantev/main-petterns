<?php
namespace App\Fuel;

use App\Exceptions\CommandException;
use App\Interfaces\CommandInterface;
use App\Interfaces\FuelableInterface;

class BurnFuelCommand implements CommandInterface
{
    public function __construct(private FuelableInterface $fuelable)
    {
    }

    public function execute(): void
    {
        $newFuelAmount = $this->fuelable->getFuel() - $this->fuelable->getSpendVelocity();
        if ($newFuelAmount < 0) {
            throw new CommandException('Недостаточно топлива');
        }
        $this->fuelable->setFuel($newFuelAmount);
    }
}