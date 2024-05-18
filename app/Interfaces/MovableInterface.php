<?php
namespace App\Interfaces;

use App\Helpers\Vector;

interface MovableInterface
{
    public function getVelocity(): Vector;
    public function getPosition(): Vector;
    public function setPosition(Vector $position): void;
}