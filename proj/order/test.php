<?php
require_once 'C:\xampp\htdocs\proj\order\order.php';
require_once 'C:\xampp\htdocs\proj\order\calculator.php';
require_once 'C:\xampp\htdocs\proj\order\notifier.php';
require_once 'C:\xampp\htdocs\proj\order\processor.php';
require_once 'C:\xampp\htdocs\proj\order\repository.php';

$order = new Order();
$order->addItem("Товар 1", 100);
$order->addItem("Товар 2", 200);

$costCalculator = new OrderCostCalculator();
$repository = new OrderRepository();
$notifier = new OrderNotifier();
$orderProcessor = new OrderProcessor($costCalculator, $repository, $notifier);

$orderProcessor->process($order);