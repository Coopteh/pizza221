// начало скрипта
<?php
//создание класса калькулятора
class Calculate {
// функция считающая что-то
function calculateTax($income) {
    if ($income < 10000) {
        return $income * 0.1;
    } elseif ($income >= 10000 && $income < 20000) {
        return $income * 0.15;
    } else {
        return $income * 0.2;
    }
}
//создание функции
function calculateBonus($salary) {
    //если
    if ($salary < 5000) {
        return $salary * 0.05;
    //иначе
    } elseif ($salary >= 5000 && $salary < 10000) {
        return $salary * 0.07;
    //иначе
    } else {
        return $salary * 0.1;
    }
}
}
// конец кода