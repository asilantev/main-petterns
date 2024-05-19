<?php

use App\Exceptions\CommandException;
use App\Interfaces\MovableInterface;
use App\Interfaces\RotatableInterface;
use App\Rotate\RotateWithChangeVelocityCommand;
use PHPUnit\Framework\TestCase;

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';
class RotateWithChangeVelocityCommandTest extends TestCase
{
    public function testChangeOfDirectionAndVelocityVector()
    {
        $rotatable = $this->createMock(RotatableInterface::class);
        $rotatable->method('getDirectionNumber')->willReturn(8);
        $rotatable->method('getAngularVelocity')->willReturn(1);

        $movable = $this->createMock(MovableInterface::class);

        $rotatable->expects($this->once())->method('setDirection');
        $movable->expects($this->once())->method('setVelocity');

        (new \App\Rotate\RotateWithChangeVelocityCommand($rotatable, $movable))->execute();
    }

    public function testVelocityVectorDoesNotChangeWhenSetDirectionThrowsException()
    {
        $rotatable = $this->createMock(RotatableInterface::class);
        $rotatable->method('getDirectionNumber')->willReturn(8);
        $rotatable->method('getAngularVelocity')->willReturn(1);
        $rotatable->method('setDirection')->willThrowException(new Exception());

        $movable = $this->createMock(MovableInterface::class);

        $rotatable->expects($this->once())->method('setDirection');
        $movable->expects($this->never())->method('setVelocity');

        $command = new RotateWithChangeVelocityCommand($rotatable, $movable);
        $this->expectException(CommandException::class);
        $command->execute();
    }
}