<?php declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Product;

interface ProductServiceInterface
{
    public function getProductById(int $id): ?Product;
    
    public function findAllProducts(): array;
    
    public function getRandomProduct(): ?Product;
    
    public function save(Product $product): Product;
    
    public function delete(int $id): bool;
}

