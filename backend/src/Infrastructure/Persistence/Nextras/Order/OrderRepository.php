<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Nextras\Order;

use Nextras\Orm\Repository\Repository;

class OrderRepository extends Repository
{
    public static function getEntityClassNames(): array
    {
        return [OrderEntity::class];
    }
}

