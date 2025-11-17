<?php declare(strict_types=1);

namespace App\Application\UseCases;

use App\Domain\Services\UserServiceInterface;

class ListUsersUseCase
{
    private UserServiceInterface $userService;
    
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function execute(): array
    {
        $users = $this->userService->findAllUsers();
        
        return array_map(fn($user) => $user->toArray(), $users);
    }
}

