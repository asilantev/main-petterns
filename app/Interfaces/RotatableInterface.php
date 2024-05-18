<?php
namespace App\Interfaces;

use App\Helpers\Direction;

interface RotatableInterface
{
    public function getDirection(): Direction;
    public function setDirection(Direction $direction): void;
    public function getAngularVelocity(): int;
    public function getDirectionNumber(): int;
}