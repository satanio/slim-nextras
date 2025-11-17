<?php declare(strict_types=1);

use Nextras\Dbal\Connection;
use Nextras\Dbal\Drivers\Mysqli\MysqliDriver;
use Nextras\Orm\Model\Model;

if (!isset($_ENV['DOCKER'])) {
    $envPath = file_exists(__DIR__ . '/../../.env') ? __DIR__ . '/../..' : __DIR__ . '/..';
    $dotenv = Dotenv\Dotenv::createImmutable($envPath);
    $dotenv->safeLoad();
}

return [
    'connection' => [
        'driver' => 'mysqli',
        'host' => $_ENV['DB_HOST'] ?? 'database',
		'username' => $_ENV['DB_USER'] ?? 'root',
		'password' => $_ENV['DB_PASSWORD'] ?? '',
		'database' => $_ENV['DB_NAME'] ?? 'slim_app',
        'port' => (int) ($_ENV['DB_PORT'] ?? 3306),
		'connectionTz' => 'Europe/Prague',
        'charset' => 'utf8mb4',
    ],
    
    'orm' => [
        'repositoryLoader' => null,
        'metadataParserFactory' => null,
        'cache' => null,
        'modelMetadataStorage' => null,
    ],
];

