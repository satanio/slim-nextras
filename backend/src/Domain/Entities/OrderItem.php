<?php declare(strict_types=1);

namespace App\Domain\Entities;

class OrderItem
{
    private ?int $id;
    private int $orderId;
    private int $productId;
    private string $productName;
    private float $productPrice;
    private int $quantity;
    
    public function __construct(
        ?int $id,
        int $orderId,
        int $productId,
        string $productName,
        float $productPrice,
        int $quantity
    ) {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->productName = $productName;
        $this->productPrice = $productPrice;
        $this->quantity = $quantity;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getOrderId(): int
    {
        return $this->orderId;
    }
    
    public function getProductId(): int
    {
        return $this->productId;
    }
    
    public function getProductName(): string
    {
        return $this->productName;
    }
    
    public function getProductPrice(): float
    {
        return $this->productPrice;
    }
    
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
    
    public function getSubtotal(): float
    {
        return $this->productPrice * $this->quantity;
    }
    
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->productId,
            'product_name' => $this->productName,
            'product_price' => $this->productPrice,
            'quantity' => $this->quantity,
            'subtotal' => $this->getSubtotal(),
        ];
    }
}

