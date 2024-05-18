<?php
namespace App\Queue;

use App\Interfaces\CommandInterface;
use App\Interfaces\CommandQueueInterface;

class CommandQueue implements CommandQueueInterface
{
    public function __construct(private array $queue = [])
    {
    }
    public function take(): ?CommandInterface
    {
        return array_shift($this->queue);
    }
    public function push(CommandInterface $command): void
    {
        $this->queue[] = $command;
    }
}