<?php
namespace App\Move;

use App\Helpers\Vector;
use App\Interfaces\CommandInterface;
use App\Interfaces\MovableInterface;

class MoveCommand implements CommandInterface
{
    private MovableInterface $movable;

    public function __construct(MovableInterface $movable)
    {
        $this->movable = $movable;
    }

    public function execute(): void
    {
        $this->movable->setPosition(
            Vector::plus(
                $this->movable->getVelocity(),
                $this->movable->getPosition()
            )
        );
    }
}