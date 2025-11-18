<?php declare(strict_types=1);

namespace App\Infrastructure\Services;

use App\Infrastructure\Persistence\Nextras\Product\ProductEntity;
use App\Infrastructure\Persistence\Nextras\Product\ProductRepository;
use App\Domain\Entities\Product;
use App\Domain\Services\ProductServiceInterface;

class ProductService implements ProductServiceInterface
{
    public function __construct(
        private readonly ProductRepository $products,
    ) {}
    
    public function getProductById(int $id): ?Product
    {
        /** @var ProductEntity|null $entity */
        $entity = $this->products->getById($id);
        
        if ($entity === null) {
            return null;
        }
        
        return $this->toDomainEntity($entity);
    }
    
    public function findAllProducts(): array
    {
        return array_map(
            fn($entity) => $this->toDomainEntity($entity),
            $this->products->findAll()->fetchAll()
        );
    }
    
    public function getRandomProduct(): ?Product
    {
        $count = $this->products->findAll()->count();
        
        if ($count === 0) {
            return null;
        }
        
        $offset = rand(0, $count - 1);
        
        $entity = $this->products->findAll()
            ->limitBy(1, $offset)
            ->fetch();

        if ($entity === null) {
            return null;
        }
        
        return $this->toDomainEntity($entity);
    }
    
    public function save(Product $product): Product
    {
        if ($product->getId() === null) {
            $entity = new ProductEntity();
        } else {
            $entity = $this->products->getById($product->getId());
            if ($entity === null) {
                throw new \RuntimeException("Product with ID {$product->getId()} not found");
            }
        }
        
        $entity->name = $product->getName();
        $entity->description = $product->getDescription();
        $entity->price = $product->getPrice();
        $entity->stock = $product->getStock();
        
        if ($product->getId() === null) {
            $entity->createdAt = new \DateTimeImmutable();
        }
        $entity->updatedAt = new \DateTimeImmutable();
        
        $this->products->persistAndFlush($entity);
        
        return $this->toDomainEntity($entity);
    }
    
    public function delete(int $id): bool
    {
        $entity = $this->products->getById($id);
        
        if ($entity === null) {
            return false;
        }
        
        $this->products->removeAndFlush($entity);
        return true;
    }

    private function toDomainEntity(ProductEntity $entity): Product
    {
        return new Product(
            $entity->id,
            $entity->name,
            $entity->description,
            $entity->price,
            $entity->stock
        );
    }
}

