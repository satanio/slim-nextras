<?php

declare(strict_types=1);

use Phinx\Db\Adapter\AdapterInterface;
use Phinx\Migration\AbstractMigration;

final class AddUserIdToOrders extends AbstractMigration
{
    public function up(): void
    {
        if ($this->isMigratingUp()) {
            $this->table('orders')
            ->addColumn('user_id', AdapterInterface::PHINX_TYPE_INTEGER, ['after' => 'id'])
            ->addForeignKey('user_id', 'users')
            ->update();
        }
    }

    public function down(): void
    {
        $this->table('orders')
        ->dropForeignKey('user_id')
        ->removeColumn('user_id')
        ->update();
    }
}

