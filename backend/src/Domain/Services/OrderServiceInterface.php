<?php declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Order;

interface OrderServiceInterface
{
    public function getOrderById(int $id): ?Order;
    
    public function findAllOrders(): array;
    
    public function createOrder(int $userId): Order;
    
    public function save(Order $order): Order;
    
    public function delete(int $id): bool;
    
    public function addProductToOrder(int $orderId, int $productId, int $quantity): Order;
    
    public function updateOrderItemQuantity(int $orderId, int $productId, int $quantity): Order;
    
    public function removeProductFromOrder(int $orderId, int $productId): Order;
}

