<?php

declare(strict_types=1);

use Phinx\Db\Adapter\AdapterInterface;
use Phinx\Migration\AbstractMigration;

final class CreateProductsTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('products')
            ->addColumn('name', AdapterInterface::PHINX_TYPE_STRING, ['limit' => 255])
            ->addColumn('description', AdapterInterface::PHINX_TYPE_TEXT)
            ->addColumn('price', AdapterInterface::PHINX_TYPE_DECIMAL, ['precision' => 10, 'scale' => 2])
            ->addColumn('stock', AdapterInterface::PHINX_TYPE_INTEGER, ['default' => 0])
            ->addTimestamps()
            ->create();
    }
}

