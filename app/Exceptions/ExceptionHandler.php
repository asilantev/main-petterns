<?php
namespace App\Exceptions;

use App\Interfaces\CommandInterface;
use App\Interfaces\ExceptionHandlerInterface;
use Ds\Map;


class ExceptionHandler implements ExceptionHandlerInterface
{
    private Map $dictionary;
    public function __construct(Map $dictionary)
    {
        $this->dictionary = $dictionary;
    }

    public function handle(CommandInterface $command, \Throwable $exception): void
    {
        $exceptionHandler = $this->findHandler($command, $exception);
        if (!$exceptionHandler) {
            throw new CommandException('Обработчик исключения не найден');
        }
        $exceptionHandler->execute();
    }

    private function findHandler(CommandInterface $command, \Throwable $exception): ?CommandInterface
    {
        return $this->dictionary[$command][$exception];
    }
}