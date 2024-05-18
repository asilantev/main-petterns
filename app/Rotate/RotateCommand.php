<?php
namespace App\Rotate;

use App\Interfaces\CommandInterface;
use App\Interfaces\RotatableInterface;

class RotateCommand implements CommandInterface
{
    private RotatableInterface $rotatable;

    public function __construct(RotatableInterface $rotatable)
    {
        $this->rotatable = $rotatable;
    }

    public function execute(): void
    {
        $this->rotatable->setDirection(
            $this->rotatable->getDirection()->next($this->rotatable->getAngularVelocity())
        );
    }
}