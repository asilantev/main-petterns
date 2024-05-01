<?php

namespace App;

use InvalidArgumentException;

class QuadraticEquationCalculator
{
    /**
     * @throws InvalidArgumentException
     */
    public function solve(float $a, float $b = 0, float $c = 0): ?array
    {
        if (is_nan($a) || is_nan($b) || is_nan($c)) {
            throw new InvalidArgumentException('NaN not supported');
        }
        if (is_infinite($a) || is_infinite($b) || is_infinite($c)) {
            throw new InvalidArgumentException('Infinite not supported');
        }
        if (abs($a) < PHP_FLOAT_EPSILON) {
            throw new InvalidArgumentException('Leading coefficient must be greater than 0');
        }

        $d = pow($b, 2) - 4 * $a * $c;


        if ($d < 0) {
            $result = [];
        } elseif ($d > 0) {
            $result = [
                (-$b + sqrt($d)) / 2 * $a,
                (-$b - sqrt($d)) / 2 * $a
            ];
        } elseif (abs($d) < PHP_FLOAT_EPSILON) {
            $result = [(-$b) / 2 * $a];
        } else {
            $result = null;
        }

        return $result;
    }
}