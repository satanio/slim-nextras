<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Nextras\User;

use DateTimeImmutable;
use Nextras\Orm\Entity\Entity;

/**
 * @property int         $id      {primary}
 * @property string      $name
 * @property string      $email
 * @property DateTimeImmutable $createdAt
 * @property DateTimeImmutable $updatedAt
 */
class UserEntity extends Entity
{
}

