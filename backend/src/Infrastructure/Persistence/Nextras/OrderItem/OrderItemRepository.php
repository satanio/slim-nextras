<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Nextras\OrderItem;

use Nextras\Orm\Repository\Repository;

class OrderItemRepository extends Repository
{
    public static function getEntityClassNames(): array
    {
        return [OrderItemEntity::class];
    }
}

