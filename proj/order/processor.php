<?php
class OrderProcessor {
    private $costCalculator;
    private $repository;
    private $notifier;

    public function __construct(OrderCostCalculator $costCalculator, OrderRepository $repository, OrderNotifier $notifier) {
        [$this->costCalculator, $this->repository, $this->notifier] = func_get_args();
    }

    public function process(Order $order) {
        $this->repository->save($order);
        $this->notifier->notify(sprintf(
            "Ваш заказ на сумму %d обработан.",
            $this->costCalculator->calculateTotal($order)
        ));
    }
}