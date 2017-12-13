<?php

namespace App\Service;

class Math
{
    public function averageRoundedInteger(int $number1, int $number2): int
    {
        return round(($number1 + $number2) / 2);
    }
}
