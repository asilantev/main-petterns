<?php
namespace App\Rotate;

use App\Helpers\Vector;
use App\Interfaces\CommandInterface;
use App\Interfaces\MovableInterface;
use App\Interfaces\RotatableInterface;

class ChangeVelocityCommand implements CommandInterface
{
    public function __construct(private RotatableInterface $rotatable, private MovableInterface $movable)
    {
    }

    public function execute(): void
    {
        $angular = $this->rotatable->getAngularVelocity() * 360 / $this->rotatable->getDirectionNumber();
        $velocity = $this->movable->getVelocity();
        $newVelocity = new Vector(
            $velocity->getX() * cos($angular) - $velocity->getY() * sin($angular),
            $velocity->getY() * cos($angular) - $velocity->getX() * sin($angular),
        );
        $this->movable->setVelocity($newVelocity);
    }
}