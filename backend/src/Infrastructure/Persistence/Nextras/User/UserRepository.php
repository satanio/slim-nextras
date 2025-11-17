<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Nextras\User;

use Nextras\Orm\Repository\Repository;

class UserRepository extends Repository
{
    public static function getEntityClassNames(): array
    {
        return [UserEntity::class];
    }
}

