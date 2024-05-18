<?php

use App\Interfaces\CommandInterface;
use App\Interfaces\CommandQueueInterface;
use App\Log\LogExceptionCommand;
use App\Log\LogExceptionHandlerCommand;
use App\Queue\DoubleRepeatAndLogExceptionHandlerCommand;
use App\Queue\RepeatAndLogExceptionCommand;
use App\Queue\RepeatCommand;
use App\Queue\RepeatExceptionHandlerCommand;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';

class CommandTest extends TestCase
{
    public function testLogExceptionCommand()
    {
        $messageText = 'Log Message';
        $e = new Exception($messageText);

        $logger = self::createStub(LoggerInterface::class);
        $logger->expects($this->once())->method('error');
        $logger->method('error')->willReturnCallback(function ($message, array $context) use ($messageText) {
            $this->assertEquals($message, $messageText);
        });

        (new LogExceptionCommand($e, $logger))->execute();
    }

    public function testLogExceptionHandlerCommand()
    {
        $e = new Exception('Log Message');

        $logger = $this->createMock(LoggerInterface::class);
        $queue = self::createStub(CommandQueueInterface::class);
        $queue->method('push')->willReturnCallback(function (CommandInterface $command) {
            $this->assertInstanceOf(LogExceptionCommand::class, $command);
        });

        (new LogExceptionHandlerCommand($queue, $e, $logger))->execute();
    }

    public function testRepeatCommand()
    {
        $command = $this->createStub(CommandInterface::class);
        $command->expects($this->once())->method('execute');
        (new RepeatCommand($command))->execute();
    }

    public function testRepeatExceptionHandlerCommand()
    {
        $command = $this->createMock(CommandInterface::class);
        $queue = $this->createMock(CommandQueueInterface::class);
        $queue->method('push')->willReturnCallback(function (CommandInterface $command) {
            $this->assertInstanceOf(RepeatCommand::class, $command);
        });

        (new RepeatExceptionHandlerCommand($queue, $command))->execute();
    }

    public function testRepeatAndLogExceptionCommand()
    {
        $e = new Exception('Test Exception');

        $command = $this->createMock(CommandInterface::class);
        $command->expects($this->once())->method('execute');
        $command->method('execute')->willThrowException($e);

        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())->method('error');

        $repeatAndLogCommand = new RepeatAndLogExceptionCommand($e, $command, $logger);
        $this->expectException(Exception::class);
        $repeatAndLogCommand->execute();
    }

    public function testDoubleRepeatAndLogExceptionCommand()
    {
        $e = new Exception('Test Exception');

        $command = $this->createMock(CommandInterface::class);
        $command->expects($this->atLeast(2))->method('execute');
        $command->method('execute')->willThrowException($e);

        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())->method('error');

        $repeatAndLogCommand = new DoubleRepeatAndLogExceptionHandlerCommand($e, $command, $logger);
        $this->expectException(Exception::class);
        $repeatAndLogCommand->execute();
    }
}