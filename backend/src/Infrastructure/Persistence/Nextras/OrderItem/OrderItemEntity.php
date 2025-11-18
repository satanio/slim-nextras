<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Nextras\OrderItem;

use App\Infrastructure\Persistence\Nextras\BaseEntityWithTimestamps;
use App\Infrastructure\Persistence\Nextras\Product\ProductEntity;
use Nextras\Orm\Relationships\ManyHasOne;
use App\Infrastructure\Persistence\Nextras\Order\OrderEntity;

/**
 * @property int         $id      {primary}
 * @property ManyHasOne|OrderEntity $order {m:1 OrderEntity::$items}
 * @property ManyHasOne|ProductEntity $product {m:1 ProductEntity, oneSided=true}
 * @property string      $productName
 * @property float       $productPrice
 * @property int         $quantity
 */
class OrderItemEntity extends BaseEntityWithTimestamps
{
}

