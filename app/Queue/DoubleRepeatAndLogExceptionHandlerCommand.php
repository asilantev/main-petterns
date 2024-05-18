<?php
namespace App\Queue;

use App\Interfaces\CommandInterface;
use Psr\Log\LoggerInterface;

class DoubleRepeatAndLogExceptionHandlerCommand implements CommandInterface
{
    public function __construct(
        private \Throwable $exception,
        private CommandInterface $command,
        private LoggerInterface $logger
    )
    {
    }

    public function execute(): void
    {
        $command = new DoubleRepeatCommand($this->command);
        try {
            $command->execute();
        } catch (\Throwable $e) {
            (new RepeatAndLogExceptionCommand($e, $command, $this->logger))->execute();
        }
    }
}