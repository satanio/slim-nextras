<?php declare(strict_types=1);

namespace App\Application\UseCases;

use App\Domain\Entities\Order;
use App\Domain\Services\OrderServiceInterface;

class ConfirmOrderUseCase
{
    private OrderServiceInterface $orderService;
    
    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function execute(int $orderId): Order
    {
        $order = $this->orderService->getOrderById($orderId);
        
        if ($order === null) {
            throw new \RuntimeException("Order with ID {$orderId} not found");
        }
        
        $order->confirm();
        $order->markAsPaid(); //TODO payment would be processed first
        
        return $this->orderService->save($order);
    }
}

