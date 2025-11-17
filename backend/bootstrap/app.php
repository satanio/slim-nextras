<?php declare(strict_types=1);

use Slim\Factory\AppFactory;
use App\Infrastructure\Middleware\TracyMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$container = require __DIR__ . '/../config/container.php';

AppFactory::setContainer($container);

$app = AppFactory::create();

$tracyConfig = require __DIR__ . '/../config/tracy.php';
$app->add(new TracyMiddleware($tracyConfig));

if ($tracyConfig['enabled'] === false) {
	$app->addErrorMiddleware(
		displayErrorDetails: false,
		logErrors: true,
		logErrorDetails: true
	);
}

require __DIR__ . '/../config/routes.php';

return $app;

