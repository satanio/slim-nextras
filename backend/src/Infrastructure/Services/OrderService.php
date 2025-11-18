<?php declare(strict_types=1);

namespace App\Infrastructure\Services;

use App\Infrastructure\Persistence\Nextras\Order\OrderEntity;
use App\Infrastructure\Persistence\Nextras\Order\OrderRepository;
use App\Infrastructure\Persistence\Nextras\OrderItem\OrderItemEntity;
use App\Infrastructure\Persistence\Nextras\OrderItem\OrderItemRepository;
use App\Infrastructure\Persistence\Nextras\Product\ProductRepository;
use App\Domain\Entities\Order;
use App\Domain\Entities\OrderItem;
use App\Domain\Services\OrderServiceInterface;

class OrderService implements OrderServiceInterface
{
    public function __construct(
        private readonly OrderRepository $orders,
        private readonly OrderItemRepository $orderItems,
        private readonly ProductRepository $products,
    ) {}
    
    public function getOrderById(int $id): ?Order
    {
        /** @var OrderEntity|null $entity */
        $entity = $this->orders->getById($id);
        
        if ($entity === null) {
            return null;
        }
        
        return $this->toDomainEntity($entity);
    }
    
    public function findAllOrders(): array
    {
        return array_map(
            fn($entity) => $this->toDomainEntity($entity),
            $this->orders->findAll()->fetchAll()
        );
    }
    
    public function createOrder(int $userId): Order
    {
        $user = $this->orders->getModel()->users->getById($userId);
        if ($user === null) {
            throw new \RuntimeException("User with ID {$userId} not found");
        }
        
        $entity = new OrderEntity();
        $entity->user = $user;
        $entity->status = Order::STATUS_PENDING;
        $entity->totalAmount = 0.0;
        $entity->createdAt = new \DateTimeImmutable();
        $entity->updatedAt = new \DateTimeImmutable();
        
        $this->orders->persistAndFlush($entity);
        
        return $this->toDomainEntity($entity);
    }
    
    public function save(Order $order): Order
    {
        if ($order->getId() === null) {
            $entity = new OrderEntity();
            $entity->createdAt = new \DateTimeImmutable();
        } else {
            $entity = $this->orders->getById($order->getId());
            if ($entity === null) {
                throw new \RuntimeException("Order with ID {$order->getId()} not found");
            }
        }
        
        $entity->status = $order->getStatus();
        $entity->totalAmount = $order->getTotalAmount();
        $entity->updatedAt = new \DateTimeImmutable();
        
        $this->orders->persistAndFlush($entity);
        
        return $this->toDomainEntity($entity);
    }
    
    public function delete(int $id): bool
    {
        $entity = $this->orders->getById($id);
        
        if ($entity === null) {
            return false;
        }
        
        $this->orders->removeAndFlush($entity);
        return true;
    }
    
    public function addProductToOrder(int $orderId, int $productId, int $quantity): Order
    {
        $orderEntity = $this->orders->getById($orderId);
        if ($orderEntity === null) {
            throw new \RuntimeException("Order with ID {$orderId} not found");
        }
        
        $productEntity = $this->products->getById($productId);
        if ($productEntity === null) {
            throw new \RuntimeException("Product with ID {$productId} not found");
        }
        
        if ($productEntity->stock < $quantity) {
            throw new \DomainException("Insufficient stock for product {$productEntity->name}");
        }
        
        $existingItem = null;
        foreach ($orderEntity->items as $item) {
            if ($item->productId === $productId) {
                $existingItem = $item;
                break;
            }
        }
        
        if ($existingItem !== null) {
            $existingItem->quantity += $quantity;
            $existingItem->updatedAt = new \DateTimeImmutable();
        } else {
            $item = new OrderItemEntity();
            $item->order = $orderEntity;
            $item->product = $productEntity;
            $item->productName = $productEntity->name;
            $item->productPrice = $productEntity->price;
            $item->quantity = $quantity;
            $item->createdAt = new \DateTimeImmutable();
            $item->updatedAt = new \DateTimeImmutable();
            
            $this->orderItems->persist($item);
        }
        
        // Update order total
        $this->recalculateOrderTotal($orderEntity);
        $orderEntity->updatedAt = new \DateTimeImmutable();
        
        $this->orders->flush();
        
        return $this->toDomainEntity($orderEntity);
    }
    
    public function updateOrderItemQuantity(int $orderId, int $productId, int $quantity): Order
    {
        $orderEntity = $this->orders->getById($orderId);
        if ($orderEntity === null) {
            throw new \RuntimeException("Order with ID {$orderId} not found");
        }
        
        $itemFound = false;
        foreach ($orderEntity->items as $item) {
            if ($item->productId === $productId) {
                if ($quantity <= 0) {
                    $this->orderItems->remove($item);
                } else {
                    $item->quantity = $quantity;
                    $item->updatedAt = new \DateTimeImmutable();
                }
                $itemFound = true;
                break;
            }
        }
        
        if (!$itemFound) {
            throw new \RuntimeException("Product {$productId} not found in order {$orderId}");
        }
        
        $this->recalculateOrderTotal($orderEntity);
        $orderEntity->updatedAt = new \DateTimeImmutable();
        
        $this->orders->flush();
        
        return $this->toDomainEntity($orderEntity);
    }
    
    public function removeProductFromOrder(int $orderId, int $productId): Order
    {
        $orderEntity = $this->orders->getById($orderId);
        if ($orderEntity === null) {
            throw new \RuntimeException("Order with ID {$orderId} not found");
        }
        
        $itemFound = false;
        foreach ($orderEntity->items as $item) {
            if ($item->productId === $productId) {
                $this->orderItems->remove($item);
                $itemFound = true;
                break;
            }
        }
        
        if (!$itemFound) {
            throw new \RuntimeException("Product {$productId} not found in order {$orderId}");
        }
        
        $this->recalculateOrderTotal($orderEntity);
        $orderEntity->updatedAt = new \DateTimeImmutable();
        
        $this->orders->flush();
        
        return $this->toDomainEntity($orderEntity);
    }
    
    private function recalculateOrderTotal(OrderEntity $orderEntity): void
    {
        $total = 0.0;
        foreach ($orderEntity->items as $item) {
            $total += $item->productPrice * $item->quantity;
        }
        $orderEntity->totalAmount = $total;
    }

    private function toDomainEntity(OrderEntity $entity): Order
    {
        $items = [];
        foreach ($entity->items as $itemEntity) {
            $items[] = new OrderItem(
                $itemEntity->id,
                $entity->id,
                $itemEntity->product->id,
                $itemEntity->productName,
                $itemEntity->productPrice,
                $itemEntity->quantity
            );
        }

        return new Order(
            $entity->id,
            $entity->user->id,
            $entity->status,
            $entity->totalAmount,
            $items
        );
    }
}

