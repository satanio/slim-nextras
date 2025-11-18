<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Nextras\Order;

use Nextras\Dbal\Platforms\Data\Fqn;
use Nextras\Orm\Mapper\Dbal\DbalMapper;

class OrderMapper extends DbalMapper
{
    protected string|Fqn|null $tableName = 'orders';
}

