// начало скрипта
<?php
// создание класса
class Complex {
    // создание функции
function complexFunction($x, $y, $z) {
    // если
    if ($x > 0 && $y < 100) {
        if ($z % 2 == 0) {
            return $x + $y;
        } else {
            return $x * $y;
        }
    } elseif ($x <= 0 || $y >= 100) {
        if ($z % 3 == 0) {
            return $x / $y;
        } else {
            return $x - $y;
        }
    } else {
        return $z;
    }
}
}
// конец скрипта