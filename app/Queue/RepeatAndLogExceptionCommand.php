<?php
namespace App\Queue;

use App\Interfaces\CommandInterface;
use App\Log\LogExceptionCommand;
use Psr\Log\LoggerInterface;

class RepeatAndLogExceptionCommand implements CommandInterface
{
    public function __construct(
        private \Throwable $e,
        private CommandInterface $command,
        private LoggerInterface $logger
    )
    {
    }

    public function execute(): void
    {
        try {
            (new RepeatCommand($this->command))->execute();
        } catch (\Throwable $e) {
            (new LogExceptionCommand($this->e, $this->logger))->execute();
            throw $e;
        }
    }
}