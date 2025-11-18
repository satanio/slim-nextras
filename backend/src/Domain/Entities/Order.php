<?php declare(strict_types=1);

namespace App\Domain\Entities;

class Order
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_PAID = 'paid';
    public const STATUS_CANCELLED = 'cancelled';
    
    private ?int $id;
    private int $userId;
    private string $status;
    private float $totalAmount;
    private array $items;
    
    public function __construct(
        ?int $id,
        int $userId,
        string $status = self::STATUS_PENDING,
        float $totalAmount = 0.0,
        array $items = []
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->status = $status;
        $this->totalAmount = $totalAmount;
        $this->items = $items;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getUserId(): int
    {
        return $this->userId;
    }
    
    public function getStatus(): string
    {
        return $this->status;
    }
    
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
    
    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }
    
    public function setTotalAmount(float $totalAmount): void
    {
        $this->totalAmount = $totalAmount;
    }
    
    public function getItems(): array
    {
        return $this->items;
    }
    
    public function setItems(array $items): void
    {
        $this->items = $items;
    }
    
    public function calculateTotal(): void
    {
        $total = 0.0;
        foreach ($this->items as $item) {
            $total += $item->getSubtotal();
        }
        $this->totalAmount = $total;
    }
    
    public function confirm(): void
    {
        if ($this->status !== self::STATUS_PENDING) {
            throw new \DomainException('Only pending orders can be confirmed');
        }
        $this->status = self::STATUS_CONFIRMED;
    }
    
    public function markAsPaid(): void
    {
        if ($this->status !== self::STATUS_CONFIRMED) {
            throw new \DomainException('Only confirmed orders can be marked as paid');
        }
        $this->status = self::STATUS_PAID;
    }
    
    public function cancel(): void
    {
        if ($this->status === self::STATUS_PAID) {
            throw new \DomainException('Paid orders cannot be cancelled');
        }
        $this->status = self::STATUS_CANCELLED;
    }
    
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'status' => $this->status,
            'total_amount' => $this->totalAmount,
            'items' => array_map(fn($item) => $item->toArray(), $this->items),
        ];
    }
}

