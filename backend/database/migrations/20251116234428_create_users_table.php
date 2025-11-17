<?php

declare(strict_types=1);

use Phinx\Db\Adapter\AdapterInterface;
use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{

    public function change(): void
    {
		$this->table('users')
			->addColumn('name', AdapterInterface::PHINX_TYPE_STRING, ['limit' => 255])
			->addColumn('email', AdapterInterface::PHINX_TYPE_STRING, ['limit' => 255])
			->addTimestamps()
			->addIndex(['email'], ['unique' => true])
			->create();
    }
}
