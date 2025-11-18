<?php declare(strict_types = 1);

namespace App\Infrastructure\Persistence\Nextras;

use Nextras\Dbal\Utils\DateTimeImmutable;
use Nextras\Orm\Entity\Entity;

/**
 * @property DateTimeImmutable $createdAt
 * @property DateTimeImmutable|null $updatedAt
 */
abstract class BaseEntityWithTimestamps extends Entity
{

	public function onBeforeInsert(): void
	{
		parent::onBeforeInsert();

		$this->createdAt = new DateTimeImmutable();
	}

	public function onBeforeUpdate(): void
	{
		parent::onBeforeUpdate();

		$this->updatedAt = new DateTimeImmutable();
	}

}