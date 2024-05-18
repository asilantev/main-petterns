<?php
namespace App\Interfaces;

interface ExceptionHandlerInterface
{
    public function handle(CommandInterface $command, \Throwable $exception): void;
}