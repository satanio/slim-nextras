<?php declare(strict_types=1);

/**
 * Phinx Configuration
 * 
 * Database migrations and seeders configuration
 */

require __DIR__ . '/vendor/autoload.php';

// Load environment variables (only if not in Docker)
if (!isset($_ENV['DOCKER'])) {
    // Try parent directory first (project root), then backend directory
    $envPath = file_exists(__DIR__ . '/../.env') ? __DIR__ . '/..' : __DIR__;
    $dotenv = Dotenv\Dotenv::createImmutable($envPath);
    $dotenv->safeLoad();
}

$credentials = [
	'adapter' => 'mysql',
	'host' => $_ENV['DB_HOST'] ?? 'localhost',
	'port' => $_ENV['DB_PORT'] ?? 3306,
	'name' => $_ENV['DB_NAME'] ?? 'slim_app',
	'user' => $_ENV['DB_USER'] ?? 'root',
	'pass' => $_ENV['DB_PASSWORD'] ?? '',
	'charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
	'collation' => 'utf8mb4_unicode_ci',
];


return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/database/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/database/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => $credentials,
        'production' => $credentials,
    ],
	'feature_flags' => [
		'unsigned_primary_keys'	=> false,
		'column_null_default' => false,
		'add_timestamps_use_datetime' => false,
	],
    'version_order' => 'creation',
];

