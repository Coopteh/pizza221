<?php
class Complex {
function complexFunction($x, $y, $z) {
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