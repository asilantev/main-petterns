<?php
namespace App\Interfaces;

interface UObjectInterface
{
    public function setProperty(string $key, mixed $value): void;
    public function getProperty(string $key): mixed;
}