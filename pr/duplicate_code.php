<?php
class Calculate {
function calculateTax($income) {
    if ($income < 10000) {
        return $income * 0.1;
    } elseif ($income >= 10000 && $income < 20000) {
        return $income * 0.15;
    } else {
        return $income * 0.2;
    }
}

function calculateBonus($salary) {
    if ($salary < 5000) {
        return $salary * 0.05;
    } elseif ($salary >= 5000 && $salary < 10000) {
        return $salary * 0.07;
    } else {
        return $salary * 0.1;
    }
}
}