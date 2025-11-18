<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Nextras;

use App\Infrastructure\Persistence\Nextras\User\UserRepository;
use App\Infrastructure\Persistence\Nextras\Product\ProductRepository;
use App\Infrastructure\Persistence\Nextras\Order\OrderRepository;
use App\Infrastructure\Persistence\Nextras\OrderItem\OrderItemRepository;
use Nextras\Orm\Model\Model;

/**
 * @property-read UserRepository $users
 * @property-read ProductRepository $products
 * @property-read OrderRepository $orders
 * @property-read OrderItemRepository $orderItems
 */
class Orm extends Model
{
}

