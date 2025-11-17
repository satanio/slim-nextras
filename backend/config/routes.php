<?php declare(strict_types=1);

use App\Interface\Http\Controllers\UserController;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

/**
 * @var App $app
 */
$app->group('/api', function (RouteCollectorProxy $group) {
    
    $group->group('/users', function (RouteCollectorProxy $group) {
        $group->get('', [UserController::class, 'index']);
        $group->post('', [UserController::class, 'store']);
        $group->get('/{id:[0-9]+}', [UserController::class, 'show']);
    });
    
});

$app->get('/health', function ($request, $response) {
    $response->getBody()->write(json_encode([
        'status' => 'ok',
        'timestamp' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
    ]));
    return $response->withHeader('Content-Type', 'application/json');
});

