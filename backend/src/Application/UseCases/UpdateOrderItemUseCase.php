<?php declare(strict_types=1);

namespace App\Application\UseCases;

use App\Domain\Entities\Order;
use App\Domain\Services\OrderServiceInterface;

class UpdateOrderItemUseCase
{
    private OrderServiceInterface $orderService;
    
    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function execute(int $orderId, int $productId, int $quantity): Order
    {
        return $this->orderService->updateOrderItemQuantity($orderId, $productId, $quantity);
    }
}

