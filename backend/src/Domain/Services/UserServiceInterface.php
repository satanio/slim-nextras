<?php declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\User;

interface UserServiceInterface
{
    /**
     * Find a user by ID
     * 
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User;
    
    /**
     * Find all users
     * 
     * @return User[]
     */
    public function findAllUsers(): array;
    
    /**
     * Save a user
     * 
     * @param User $user
     * @return User
     */
    public function save(User $user): User;
    
    /**
     * Delete a user
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}

