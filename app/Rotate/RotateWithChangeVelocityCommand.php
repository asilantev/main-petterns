<?php
namespace App\Rotate;

use App\Helpers\MacroCommand;
use App\Interfaces\CommandInterface;
use App\Interfaces\MovableInterface;
use App\Interfaces\RotatableInterface;

class RotateWithChangeVelocityCommand implements CommandInterface
{
    private CommandInterface $command;
    public function __construct(RotatableInterface $rotatable, MovableInterface $movable)
    {
        $this->command = new MacroCommand(
            new RotateCommand($rotatable),
            new ChangeVelocityCommand($rotatable, $movable)
        );
    }

    public function execute(): void
    {
        $this->command->execute();
    }
}