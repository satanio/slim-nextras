<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Nextras\Order;

use App\Infrastructure\Persistence\Nextras\BaseEntityWithTimestamps;
use Nextras\Orm\Relationships\ManyHasOne;
use Nextras\Orm\Relationships\OneHasMany;
use App\Infrastructure\Persistence\Nextras\OrderItem\OrderItemEntity;
use App\Infrastructure\Persistence\Nextras\User\UserEntity;

/**
 * @property int         $id      {primary}
 * @property ManyHasOne|UserEntity $user {m:1 UserEntity::$orders}
 * @property string      $status
 * @property float       $totalAmount
 * @property OneHasMany|OrderItemEntity[] $items {1:m OrderItemEntity::$order}
 */
class OrderEntity extends BaseEntityWithTimestamps
{
}

