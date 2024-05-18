<?php
namespace App\Queue;

use App\Interfaces\CommandInterface;

class RepeatCommand implements CommandInterface
{
    public function __construct(private CommandInterface $command)
    {
    }

    public function execute(): void
    {
        $this->command->execute();
    }
}