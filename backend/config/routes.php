<?php declare(strict_types=1);

use App\Interface\Http\Controllers\OrderController;
use App\Interface\Http\Controllers\ProductController;
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
    
    $group->group('/products', function (RouteCollectorProxy $group) {
        $group->get('/random', [ProductController::class, 'random']);
    });
    
    $group->group('/orders', function (RouteCollectorProxy $group) {
        $group->post('', [OrderController::class, 'create']);
        $group->get('/{id:[0-9]+}', [OrderController::class, 'show']);
        $group->post('/{id:[0-9]+}/items', [OrderController::class, 'addProduct']);
        $group->put('/{id:[0-9]+}/items', [OrderController::class, 'updateItem']);
        $group->post('/{id:[0-9]+}/confirm', [OrderController::class, 'confirm']);
        $group->delete('/{id:[0-9]+}', [OrderController::class, 'delete']);
    });
    
});

$app->get('/health', function ($request, $response) {
    $response->getBody()->write(json_encode([
        'status' => 'ok',
        'timestamp' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
    ]));
    return $response->withHeader('Content-Type', 'application/json');
});

