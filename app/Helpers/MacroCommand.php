<?php

namespace App\Helpers;

use App\Exceptions\CommandException;
use App\Interfaces\CommandInterface;

class MacroCommand implements CommandInterface
{
    /** @var CommandInterface[] $commands */
    private array $commands;
    public function __construct(CommandInterface ...$commands)
    {
        $this->commands = $commands;
    }

    public function execute(): void
    {
        foreach ($this->commands as $command) {
            try {
                $command->execute();
            } catch (\Throwable $e) {
                throw new CommandException($e->getMessage(), $e->getCode(), $e);
            }
        }
    }
}