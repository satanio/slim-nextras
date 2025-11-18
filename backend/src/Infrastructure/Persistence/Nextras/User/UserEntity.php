<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Nextras\User;

use App\Infrastructure\Persistence\Nextras\BaseEntityWithTimestamps;
use Nextras\Orm\Relationships\OneHasMany;
use App\Infrastructure\Persistence\Nextras\Order\OrderEntity;

/**
 * @property int         $id      {primary}
 * @property string      $name
 * @property string      $email
 * @property OneHasMany|OrderEntity[] $orders {1:m OrderEntity::$user}
 */
class UserEntity extends BaseEntityWithTimestamps
{
}

