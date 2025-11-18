<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Nextras\Product;

use Nextras\Dbal\Platforms\Data\Fqn;
use Nextras\Orm\Mapper\Dbal\DbalMapper;

class ProductMapper extends DbalMapper
{
    protected string|Fqn|null $tableName = 'products';
}

