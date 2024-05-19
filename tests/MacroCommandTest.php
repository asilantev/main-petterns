<?php

use App\Exceptions\CommandException;
use App\Helpers\MacroCommand;
use App\Interfaces\CommandInterface;
use PHPUnit\Framework\TestCase;

require_once $_SERVER['DOCUMENT_ROOT'] . "vendor/autoload.php";
class MacroCommandTest extends TestCase
{
    public function testExecuteAllCommands()
    {
        $commands = [];
        for ($i = 0; $i < 3; $i++) {
            $command = $this->createMock(CommandInterface::class);
            $command->expects($this->once())->method('execute');
            $commands[] = $command;
        }

        (new MacroCommand(...$commands))->execute();
    }

    public function testExecutionBreaksOnException()
    {
        $command1 = $this->createMock(CommandInterface::class);
        $command1->expects($this->once())->method('execute');

        $command2 = $this->createMock(CommandInterface::class);
        $command2->method('execute')->willThrowException(new CommandException());

        $command3 = $this->createMock(CommandInterface::class);
        $command3->expects($this->never())->method('execute');

        $macroCommand = new MacroCommand($command1, $command2, $command3);
        $this->expectException(CommandException::class);
        $macroCommand->execute();
    }
}