<?php declare(strict_types=1);

namespace App\Application\UseCases;

use App\Domain\Entities\Product;
use App\Domain\Services\ProductServiceInterface;

class GetRandomProductUseCase
{
    private ProductServiceInterface $productService;
    
    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function execute(): ?Product
    {
        return $this->productService->getRandomProduct();
    }
}

