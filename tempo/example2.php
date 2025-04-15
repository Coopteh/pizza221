<?php

function divide(float $a, float $b): float
{   
    return $a / $b;
}

try {
    echo divide(10, 3);
} catch (DivisionByZeroError $e) {
    echo $e->getMessage();
}