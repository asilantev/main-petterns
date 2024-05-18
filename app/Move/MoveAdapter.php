<?php
namespace App\Move;

use App\Helpers\Vector;
use App\Interfaces\MovableInterface;
use App\Interfaces\UObjectInterface;

class MoveAdapter implements MovableInterface
{
    private UObjectInterface $targetObject;
    public function __construct(UObjectInterface $targetObject)
    {
        $this->targetObject = $targetObject;
    }
    public function getVelocity(): Vector
    {
        return $this->targetObject->getProperty('velocity');
    }
    public function getPosition(): Vector
    {
        return $this->targetObject->getProperty('position');
    }
    public function setPosition(Vector $position): void
    {
        $this->targetObject->setProperty('position', $position);
    }
}