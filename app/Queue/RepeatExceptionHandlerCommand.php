<?php
namespace App\Queue;

use App\Interfaces\CommandInterface;
use App\Interfaces\CommandQueueInterface;

class RepeatExceptionHandlerCommand implements CommandInterface
{
    public function __construct(
        private CommandQueueInterface $queue,
        private CommandInterface $command
    )
    {
    }

    public function execute(): void
    {
        $this->queue->push(new RepeatCommand($this->command));
    }
}