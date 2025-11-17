<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Nextras\User;

use Nextras\Dbal\Platforms\Data\Fqn;
use Nextras\Orm\Mapper\Dbal\DbalMapper;

class UserMapper extends DbalMapper
{
    protected string|Fqn|null $tableName = 'users';
}

