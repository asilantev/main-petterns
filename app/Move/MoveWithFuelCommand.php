<?php
namespace App\Move;

use App\Fuel\BurnFuelCommand;
use App\Fuel\CheckFuelCommand;
use App\Helpers\MacroCommand;
use App\Interfaces\CommandInterface;
use App\Interfaces\FuelableInterface;
use App\Interfaces\MovableInterface;

class MoveWithFuelCommand implements CommandInterface
{
    private CommandInterface $command;
    public function __construct(MovableInterface $movable, FuelableInterface $fuelable)
    {
        $this->command = new MacroCommand(
            new CheckFuelCommand($fuelable),
            new MoveCommand($movable),
            new BurnFuelCommand($fuelable)
        );
    }

    public function execute(): void
    {
        $this->command->execute();
    }
}