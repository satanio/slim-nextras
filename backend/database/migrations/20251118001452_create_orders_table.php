<?php

declare(strict_types=1);

use Phinx\Db\Adapter\AdapterInterface;
use Phinx\Migration\AbstractMigration;

final class CreateOrdersTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('orders')
            ->addColumn('status', AdapterInterface::PHINX_TYPE_STRING, ['limit' => 50, 'default' => 'pending'])
            ->addColumn('total_amount', AdapterInterface::PHINX_TYPE_DECIMAL, ['precision' => 10, 'scale' => 2, 'default' => 0.00])
            ->addTimestamps()
            ->create();
    }
}

