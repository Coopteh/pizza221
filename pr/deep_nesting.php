<?php
class Process {
function processData($data) {
    foreach ($data as $item) {
        if ($item['status'] === 'active') {
            if ($item['type'] === 'order') {
                if ($item['amount'] > 100) {
                    // Process order
                } else {
                    // Ignore small orders
                }
            } elseif ($item['type'] === 'payment') {
                if ($item['amount'] > 50) {
                    // Process payment
                } else {
                    // Ignore small payments
                }
            } else {
                // Unknown type
            }
        } else {
            // Inactive item
        }
    }
}
}