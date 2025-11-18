<?php declare(strict_types=1);

namespace App\Application\UseCases;

use App\Domain\Entities\Order;
use App\Domain\Services\OrderServiceInterface;

class CreateOrderUseCase
{
    private OrderServiceInterface $orderService;
    
    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function execute(int $userId): Order
    {
        return $this->orderService->createOrder($userId);
    }
}

