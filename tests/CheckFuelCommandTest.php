<?php

use App\Exceptions\CommandException;
use App\Fuel\CheckFuelCommand;
use App\Interfaces\FuelableInterface;
use PHPUnit\Framework\TestCase;

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';

class CheckFuelCommandTest extends TestCase
{
    public function testNotEnoughFuelInTank()
    {
        $mock = $this->createMock(FuelableInterface::class);
        $mock->method('getFuel')->willReturn(20);
        $mock->method('getSpendVelocity')->willReturn(22);

        $command = new CheckFuelCommand($mock);
        $this->expectException(CommandException::class);
        $command->execute();
    }

    public function testCantGetFuel()
    {
        $mock = $this->createMock(FuelableInterface::class);
        $mock->method('getFuel')->willThrowException(new TypeError());
        $mock->method('getSpendVelocity')->willReturn(22);

        $command = new CheckFuelCommand($mock);
        $this->expectException(TypeError::class);
        $command->execute();
    }

    public function testCantGetSpendVelocity()
    {
        $mock = $this->createMock(FuelableInterface::class);
        $mock->method('getFuel')->willReturn(3);
        $mock->method('getSpendVelocity')->willThrowException(new TypeError());

        $command = new CheckFuelCommand($mock);
        $this->expectException(TypeError::class);
        $command->execute();
    }
}