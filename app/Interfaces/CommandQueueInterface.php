<?php
namespace App\Interfaces;

interface CommandQueueInterface
{
    public function take(): ?CommandInterface;
    public function push(CommandInterface $command): void;
}