<?php

use App\Helpers\Direction;
use App\Interfaces\RotatableInterface;
use App\Rotate\RotateCommand;
use PHPUnit\Framework\TestCase;

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';

class RotateCommandTest extends TestCase
{
    public function testRotateCommandChangeDirection()
    {
        $rotatableMock = $this->createMock(RotatableInterface::class);
        $rotatableMock->method('getDirection')->willReturn(new Direction(2, 8));
        $rotatableMock->method('getAngularVelocity')->willReturn(7);

        $rotatableMock->method('setDirection')->willReturnCallback(function (Direction $newDirection) {
           $this->assertEquals($newDirection->getDirection(), 1, 'Ошибка вращения объекта');
        });

        (new RotateCommand($rotatableMock))->execute();
    }

    public function testRotateCommandUndefinedDirection()
    {
        $rotatableMock = $this->createMock(RotatableInterface::class);
        $rotatableMock->method('getDirection')->willThrowException(new UnexpectedValueException());
        $rotatableMock->method('getAngularVelocity')->willReturn(7);

        $rotateCommand = new RotateCommand($rotatableMock);
        $this->expectException(UnexpectedValueException::class);
        $rotateCommand->execute();
    }

    public function testRotateCommandUndefinedAngularVelocity()
    {
        $rotatableMock = $this->createMock(RotatableInterface::class);
        $rotatableMock->method('getDirection')->willReturn(new Direction(2,8));
        $rotatableMock->method('getAngularVelocity')->willThrowException(new UnexpectedValueException());

        $rotateCommand = new RotateCommand($rotatableMock);
        $this->expectException(UnexpectedValueException::class);
        $rotateCommand->execute();
    }

    public function testRotateCommandCantSetDirection()
    {
        $rotatableMock = $this->createMock(RotatableInterface::class);
        $rotatableMock->method('getDirection')->willReturn(new Direction(2, 8));
        $rotatableMock->method('getAngularVelocity')->willReturn(7);
        $rotatableMock->method('setDirection')->willThrowException(new Exception());

        $rotateCommand = new RotateCommand($rotatableMock);
        $this->expectException(Exception::class);
        $rotateCommand->execute();
    }
}