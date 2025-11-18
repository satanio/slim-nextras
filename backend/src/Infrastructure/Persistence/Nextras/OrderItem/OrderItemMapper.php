<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Nextras\OrderItem;

use Nextras\Dbal\Platforms\Data\Fqn;
use Nextras\Orm\Mapper\Dbal\DbalMapper;

class OrderItemMapper extends DbalMapper
{
    protected string|Fqn|null $tableName = 'order_items';
}

