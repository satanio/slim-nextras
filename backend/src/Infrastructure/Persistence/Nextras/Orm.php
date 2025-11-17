<?php declare(strict_types=1);

namespace App\Infrastructure\Persistence\Nextras;

use App\Infrastructure\Persistence\Nextras\User\UserRepository;
use Nextras\Orm\Model\Model;

/**
 * @property-read UserRepository $users
 */
class Orm extends Model
{
}

