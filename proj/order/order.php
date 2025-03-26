<?php
class Order {
    private $items = [];
    
    public function addItem($item, $price) {
        $this->items[$item] = $price;
    }
    
    public function getItems() {
        return array_values($this->items);
    }
}