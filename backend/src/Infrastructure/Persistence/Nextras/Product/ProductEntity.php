<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Nextras\Product;

use App\Infrastructure\Persistence\Nextras\BaseEntityWithTimestamps;

/**
 * @property int         $id      {primary}
 * @property string      $name
 * @property string      $description
 * @property float       $price
 * @property int         $stock
 */
class ProductEntity extends BaseEntityWithTimestamps
{
}

