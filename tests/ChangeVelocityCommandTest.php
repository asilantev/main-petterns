<?php

use App\Helpers\Direction;
use App\Helpers\Vector;
use App\Interfaces\MovableInterface;
use App\Interfaces\RotatableInterface;
use App\Rotate\ChangeVelocityCommand;
use PHPUnit\Framework\TestCase;

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';

class ChangeVelocityCommandTest extends TestCase
{
    public function testImmovableObject()
    {
        $movable = $this->createMock(MovableInterface::class);
        $movable->method('getVelocity')->willReturn(new Vector(0,0));
        $movable->method('getPosition')->willReturn(new Vector(0,0));

        $rotatable = $this->createMock(RotatableInterface::class);
        $rotatable->method('getDirection')->willReturn(new Direction(1,8));
        $rotatable->method('getAngularVelocity')->willReturn(1);
        $rotatable->method('getDirectionNumber')->willReturn(8);

        $movable->method('setVelocity')->willReturnCallback(function (Vector $newVector) {
            $message = 'По недвижимому объекту произошло смещение мнгновенной скорости по оси %s';
            $this->assertEquals($newVector->getX(), 0, sprintf($message, 'X'));
            $this->assertEquals($newVector->getY(), 0, sprintf($message, 'Y'));
        });

        (new ChangeVelocityCommand($rotatable, $movable))->execute();
    }
}