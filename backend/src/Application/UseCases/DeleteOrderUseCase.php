<?php declare(strict_types=1);

namespace App\Application\UseCases;

use App\Domain\Services\OrderServiceInterface;

class DeleteOrderUseCase
{
    private OrderServiceInterface $orderService;
    
    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function execute(int $orderId): bool
    {
        return $this->orderService->delete($orderId);
    }
}

