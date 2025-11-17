<?php declare(strict_types=1);

namespace App\Application\UseCases;

use App\Domain\Entities\User;
use App\Domain\Services\UserServiceInterface;

class GetUserUseCase
{
    private UserServiceInterface $userService;
    
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function execute(int $userId): ?User
    {
        return $this->userService->getUserById($userId);
    }
}

