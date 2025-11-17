<?php declare(strict_types=1);

use App\Application\UseCases\CreateUserUseCase;
use App\Application\UseCases\GetUserUseCase;
use App\Application\UseCases\ListUsersUseCase;
use App\Domain\Services\UserServiceInterface;
use App\Interface\Http\Controllers\UserController;
use DI\ContainerBuilder;
use Nette\Caching\Cache;
use Nextras\Dbal\Connection;
use Nextras\Orm\Model\Model;
use Psr\Container\ContainerInterface;
use Nextras\Orm\Model\SimpleRepositoryLoader;
use Nextras\Orm\Model\MetadataStorage;
use Nextras\Orm\Entity\Reflection\MetadataParserFactory;
use Nette\Caching\Storages\DevNullStorage;
use Nextras\Orm\Mapper\Dbal\DbalMapperCoordinator;
use App\Infrastructure\Persistence\Nextras\Orm;
use App\Infrastructure\Persistence\Nextras\User\UserMapper;
use App\Infrastructure\Persistence\Nextras\User\UserRepository;
use App\Infrastructure\Services\UserService;
use function DI\autowire;
use function DI\get;

$containerBuilder = new ContainerBuilder();

$containerBuilder->useAutowiring(true);

$containerBuilder->useAttributes(true);

$containerBuilder->addDefinitions([
    // Database Configuration
    'database.config' => function() {
        return require __DIR__ . '/database.php';
    },
    
    // no cache for now use FileStorage if needed
    Cache::class => function() {
        return new Cache(new DevNullStorage());
    },
    
    Connection::class => function(ContainerInterface $c) {
        $config = $c->get('database.config')['connection'];
        return new Connection($config);
    },
    
    DbalMapperCoordinator::class => function(ContainerInterface $c) {
        return new DbalMapperCoordinator($c->get(Connection::class));
    },
    
    
    UserMapper::class => function(ContainerInterface $c) {
        return new UserMapper(
            $c->get(Connection::class),
            $c->get(DbalMapperCoordinator::class),
            $c->get(Cache::class)
        );
    },

     Orm::class => function(ContainerInterface $c) {
         $repositories = [
             'users' => new UserRepository($c->get(UserMapper::class)),
         ];

         $config = Model::getConfiguration($repositories);
         $parser = new MetadataParserFactory();
         $loader = new SimpleRepositoryLoader(array_values($repositories));
         $metadata = new MetadataStorage($config[2], $c->get(Cache::class), $parser, $loader);
         $orm = new Orm($config, $loader, $metadata);

         foreach ($repositories as $repository) {
             $repository->setModel($orm);
         }

         return $orm;
     },

    UserRepository::class => function(ContainerInterface $c) {
        return $c->get(Orm::class)->users;
    },


    UserService::class => autowire(),
    UserServiceInterface::class => get(UserService::class),
    
    // Use Cases
    CreateUserUseCase::class => autowire(),
    GetUserUseCase::class => autowire(),
    ListUsersUseCase::class => autowire(),
    
    // Controllers
    UserController::class => autowire(),
]);

return $containerBuilder->build();

