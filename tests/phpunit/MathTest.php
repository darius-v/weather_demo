<?php

use App\Service\Math;
use PHPUnit\Framework\TestCase;

class MathTest extends TestCase
{
    public function testAverageRoundedInteger()
    {
        $math = new Math();

        $this->assertEquals(4, $math->averageRoundedInteger(5, 2));
    }
}