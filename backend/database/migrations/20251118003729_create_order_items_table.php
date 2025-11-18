<?php

declare(strict_types=1);

use Phinx\Db\Adapter\AdapterInterface;
use Phinx\Migration\AbstractMigration;

final class CreateOrderItemsTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('order_items')
            ->addColumn('order_id', AdapterInterface::PHINX_TYPE_INTEGER)
            ->addColumn('product_id', AdapterInterface::PHINX_TYPE_INTEGER)
            ->addColumn('product_name', AdapterInterface::PHINX_TYPE_STRING, ['limit' => 255])
            ->addColumn('product_price', AdapterInterface::PHINX_TYPE_DECIMAL, ['precision' => 10, 'scale' => 2])
            ->addColumn('quantity', AdapterInterface::PHINX_TYPE_INTEGER, ['default' => 1])
            ->addTimestamps()
            ->addForeignKey('order_id', 'orders')
            ->addForeignKey('product_id', 'products')
            ->create();
    }
}

