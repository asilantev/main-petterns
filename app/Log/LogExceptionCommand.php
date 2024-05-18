<?php
namespace App\Log;

use App\Interfaces\CommandInterface;
use Psr\Log\LoggerInterface;

class LogExceptionCommand implements CommandInterface
{
    public function __construct(private \Throwable $exception, private LoggerInterface $logger)
    {
    }

    public function execute(): void
    {
        $this->logger->error(
            $this->exception->getMessage(),
            ['exception' => $this->exception]
        );
    }
}