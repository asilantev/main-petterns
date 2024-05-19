<?php

use App\Exceptions\CommandException;
use App\Helpers\Vector;
use App\Interfaces\FuelableInterface;
use App\Interfaces\MovableInterface;
use App\Move\MoveWithFuelCommand;
use PHPUnit\Framework\TestCase;

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';

class MoveWithFuelCommandTest extends TestCase
{
    public function testPositive()
    {
        $fuelable = $this->createMock(FuelableInterface::class);
        $fuelable->method('getFuel')->willReturn(30);
        $fuelable->method('getSpendVelocity')->willReturn(20);

        $movable = $this->createMock(MovableInterface::class);
        $movable->method('getVelocity')->willReturn(new Vector(-7, 3));
        $movable->method('getPosition')->willReturn(new Vector(12, 5));

        $fuelable->expects($this->atLeastOnce())->method('getFuel');
        $movable->expects($this->once())->method('setPosition');
        $fuelable->expects($this->once())->method('setFuel');

        (new MoveWithFuelCommand($movable, $fuelable))->execute();
    }

    public function testObjectDoesNotMoveWithEmptyTank()
    {
        $fuelable = $this->createMock(FuelableInterface::class);
        $fuelable->method('getFuel')->willReturn(0);
        $fuelable->method('getSpendVelocity')->willReturn(20);

        $movable = $this->createMock(MovableInterface::class);
        $movable->method('getVelocity')->willReturn(new Vector(-7, 3));
        $movable->method('getPosition')->willReturn(new Vector(12, 5));

        $fuelable->expects($this->atLeastOnce())->method('getFuel');
        $movable->expects($this->never())->method('setPosition');
        $fuelable->expects($this->never())->method('setFuel');

        $command = new MoveWithFuelCommand($movable, $fuelable);
        $this->expectException(CommandException::class);
        $command->execute();
    }

    public function testFuelDoesNotBurnWhenMoveCommandThrowsException()
    {
        $fuelable = $this->createMock(FuelableInterface::class);
        $fuelable->method('getFuel')->willReturn(0);
        $fuelable->method('getSpendVelocity')->willReturn(20);

        $movable = $this->createMock(MovableInterface::class);
        $movable->method('getVelocity')->willThrowException(new TypeError());
        $movable->method('getPosition')->willReturn(new Vector(12, 5));

        $fuelable->expects($this->never())->method('setFuel');

        $command = new MoveWithFuelCommand($movable, $fuelable);
        $this->expectException(CommandException::class);
        $command->execute();
    }
}