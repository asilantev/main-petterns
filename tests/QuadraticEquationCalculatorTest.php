<?php
require_once $_SERVER['DOCUMENT_ROOT'].'vendor/autoload.php';

use App\QuadraticEquationCalculator;
use PHPUnit\Framework\TestCase;

class QuadraticEquationCalculatorTest extends TestCase
{
    private QuadraticEquationCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new QuadraticEquationCalculator();
    }

    public function testNoRoots()
    {
        $roots = $this->calculator->solve(1, 0, 1);
        $this->assertCount(0, $roots);
    }

    public function testSolveReturnsTwoRealSquareRoots()
    {
        $roots = $this->calculator->solve(1, 0, -1);
        $this->assertCount(2, $roots);
        $this->assertEquals(1, $roots[0]);
        $this->assertEquals(-1, $roots[1]);
    }

    public function testSolveReturnsOneRootOfMultiplicity2()
    {
        $roots = $this->calculator->solve(1, 2, 1);
        $this->assertCount(1, $roots);
        $this->assertEquals(-1, $roots[0]);
    }

    public function testLeadingCoefficientException()
    {
        $this->calculator->solve(PHP_FLOAT_EPSILON, 1);
        $this->expectException(InvalidArgumentException::class);
        $this->calculator->solve(0, 1);
    }

    public function testSolveThrowsExceptionForSpecialNumbers()
    {
        foreach ([INF, NAN] as $specialValue) {
            for ($i = 0; $i < 3; $i++) {
                $arguments = [1, 1, 2, $i => $specialValue];
                try {
                    call_user_func_array([$this->calculator, 'solve'], $arguments);
                    $errorMessage = sprintf("Argument %d: special number %s does not throw an exception",
                        $i + 1, $specialValue);
                    $this->fail($errorMessage);
                } catch (InvalidArgumentException $e) {
                }
            }
        }
    }

}