<?php


function divide(float $a, float $b): float
{
    if ($b == 0) { // Check for division by zero
        throw new InvalidArgumentException("Division by zero is not allowed.");
    }
    return $a / $b;
}

echo divide(10, 3);