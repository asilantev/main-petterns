<?php
namespace App\Rotate;

use App\Helpers\Direction;
use App\Interfaces\RotatableInterface;
use App\Interfaces\UObjectInterface;

class RotateAdapter implements RotatableInterface
{
    private UObjectInterface $targetObject;
    public function __construct(UObjectInterface $targetObject)
    {
        $this->targetObject = $targetObject;
    }

    public function getDirection(): Direction
    {
        return $this->targetObject->getProperty('direction');
    }

    public function setDirection(Direction $direction): void
    {
        $this->targetObject->setProperty('direction', $direction);
    }

    public function getAngularVelocity(): int
    {
        return $this->targetObject->getProperty('angularVelocity');
    }

    public function getDirectionNumber(): int
    {
        return $this->getDirection()->getDirectionNumber();
    }
}