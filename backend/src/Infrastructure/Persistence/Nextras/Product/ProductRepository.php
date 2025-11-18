<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Nextras\Product;

use Nextras\Orm\Repository\Repository;

class ProductRepository extends Repository
{
    public static function getEntityClassNames(): array
    {
        return [ProductEntity::class];
    }
    
}

