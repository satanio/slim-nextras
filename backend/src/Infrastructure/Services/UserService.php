<?php declare(strict_types=1);

namespace App\Infrastructure\Services;

use App\Domain\Entities\User;
use App\Domain\Services\UserServiceInterface;
use App\Infrastructure\Persistence\Nextras\User\UserEntity;
use App\Infrastructure\Persistence\Nextras\User\UserRepository;

class UserService implements UserServiceInterface
{
    public function __construct(
		private readonly UserRepository $users,
    ) {}
    
    public function getUserById(int $id): ?User
    {
        /** @var UserEntity|null $entity */
        $entity = $this->users->getById($id);
        
        if ($entity === null) {
            return null;
        }
        
        return $this->toDomainEntity($entity);
    }
    
    public function findAllUsers(): array
    {
        return array_map(
            fn($entity) => $this->toDomainEntity($entity),
            $this->users->findAll()->fetchAll()
        );
    }
    
    public function save(User $user): User
    {
        if ($user->getId() === null) {
            $entity = new UserEntity();
        } else {
            $entity = $this->users->getById($user->getId());
            if ($entity === null) {
                throw new \RuntimeException("User with ID {$user->getId()} not found");
            }
        }
        
        $entity->name = $user->getName();
        $entity->email = $user->getEmail();
        
        if ($user->getId() === null) {
            $entity->createdAt = new \DateTimeImmutable();
        }
        $entity->updatedAt = new \DateTimeImmutable();
        
        $this->users->persistAndFlush($entity);
        
        return $this->toDomainEntity($entity);
    }
    
    public function delete(int $id): bool
    {
        $entity = $this->users->getById($id);
        
        if ($entity === null) {
            return false;
        }
        
        $this->users->removeAndFlush($entity);
        return true;
    }

    private function toDomainEntity(UserEntity $entity): User
    {
        return new User(
            $entity->id,
            $entity->name,
            $entity->email
        );
    }
}

