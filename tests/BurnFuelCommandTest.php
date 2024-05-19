<?php

use App\Fuel\BurnFuelCommand;
use App\Interfaces\FuelableInterface;
use PHPUnit\Framework\TestCase;

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';

class BurnFuelCommandTest extends TestCase
{
    public function testSpendFuel()
    {
        $mock = $this->createMock(FuelableInterface::class);
        $mock->method('getFuel')->willReturn(30);
        $mock->method('getSpendVelocity')->willReturn(21);

        $mock->method('setFuel')->willReturnCallback(function (int $newAmount) {
            $this->assertEquals($newAmount, 9, 'Ошибка в списании топлива');
        });

        (new BurnFuelCommand($mock))->execute();
    }

    public function testCantGetFuel()
    {
        $mock = $this->createMock(FuelableInterface::class);
        $mock->method('getFuel')->willThrowException(new TypeError());
        $mock->method('getSpendVelocity')->willReturn(21);

        $command = new BurnFuelCommand($mock);
        $this->expectException(TypeError::class);
        $command->execute();
    }

    public function testCantGetSpendVelocity()
    {
        $mock = $this->createMock(FuelableInterface::class);
        $mock->method('getFuel')->willReturn(3);
        $mock->method('getSpendVelocity')->willThrowException(new TypeError());

        $command = new BurnFuelCommand($mock);
        $this->expectException(TypeError::class);
        $command->execute();
    }
}