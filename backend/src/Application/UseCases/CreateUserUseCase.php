<?php declare(strict_types=1);

namespace App\Application\UseCases;

use App\Domain\Entities\User;
use App\Domain\Services\UserServiceInterface;

class CreateUserUseCase
{
    private UserServiceInterface $userService;
    
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }


    public function execute(string $name, string $email): User
    {
        $user = new User(null, $name, $email);
        
        return $this->userService->save($user);
    }
}

