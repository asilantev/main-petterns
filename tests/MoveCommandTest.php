<?php

use App\Helpers\Vector;
use App\Interfaces\MovableInterface;
use App\Move\MoveCommand;
use PHPUnit\Framework\TestCase;

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';

class MoveCommandTest extends TestCase
{
    public function testMoveCommandChangePosition()
    {
        $movableMock = $this->createMock(MovableInterface::class);
        $movableMock->method('getVelocity')->willReturn(new Vector(-7, 3));
        $movableMock->method('getPosition')->willReturn(new Vector(12,5));

        $movableMock->method('setPosition')->willReturnCallback(function (Vector $newPosition) {
            $this->assertEquals($newPosition->getX(), 5, 'Ошибка в смещении объекта по оси X');
            $this->assertEquals($newPosition->getY(), 8, 'Ошибка в смещении объекта по оси Y');
        });

        (new MoveCommand($movableMock))->execute();
    }

    public function testMoveCommandUndefinedPosition()
    {
        $movableMock = $this->createMock(MovableInterface::class);
        $movableMock->method('getPosition')->willThrowException(new UnexpectedValueException());
        $movableMock->method('getVelocity')->willReturn(new Vector(11, 3));

        $moveCommand = new MoveCommand($movableMock);
        $this->expectException(UnexpectedValueException::class);
        $moveCommand->execute();
    }

    public function testMoveCommandUndefinedVelocity()
    {
        $movableMock = $this->createMock(MovableInterface::class);
        $movableMock->method('getPosition')->willReturn(new Vector(11, 3));
        $movableMock->method('getVelocity')->willThrowException(new UnexpectedValueException());

        $moveCommand = new MoveCommand($movableMock);
        $this->expectException(UnexpectedValueException::class);
        $moveCommand->execute();
    }

    public function testMoveCommandCantSetPosition()
    {
        $movableMock = $this->createMock(MovableInterface::class);
        $movableMock->method('setPosition')->willThrowException(new Exception());
        $movableMock->method('getPosition')->willReturn(new Vector(11,3));
        $movableMock->method('getVelocity')->willReturn(new Vector(-3,2));

        $moveCommand = new MoveCommand($movableMock);
        $this->expectException(Exception::class);
        $moveCommand->execute();
    }
}