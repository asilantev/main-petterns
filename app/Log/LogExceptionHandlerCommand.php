<?php
namespace App\Log;

use App\Interfaces\CommandInterface;
use App\Interfaces\CommandQueueInterface;
use Psr\Log\LoggerInterface;

class LogExceptionHandlerCommand implements CommandInterface
{
    public function __construct(
        private CommandQueueInterface $queue,
        private \Throwable $exception,
        private LoggerInterface $logger
    )
    {
    }

    public function execute(): void
    {
        $this->queue->push(new LogExceptionCommand($this->exception, $this->logger));
    }
}