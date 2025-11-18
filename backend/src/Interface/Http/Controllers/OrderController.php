<?php declare(strict_types=1);

namespace App\Interface\Http\Controllers;

use App\Application\UseCases\CreateOrderUseCase;
use App\Application\UseCases\GetOrderUseCase;
use App\Application\UseCases\AddProductToOrderUseCase;
use App\Application\UseCases\UpdateOrderItemUseCase;
use App\Application\UseCases\ConfirmOrderUseCase;
use App\Application\UseCases\DeleteOrderUseCase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class OrderController extends BaseController
{

    
    public function __construct(
        private readonly CreateOrderUseCase $createOrderUseCase,
        private readonly GetOrderUseCase $getOrderUseCase,
        private readonly AddProductToOrderUseCase $addProductToOrderUseCase,
        private readonly UpdateOrderItemUseCase $updateOrderItemUseCase,
        private readonly ConfirmOrderUseCase $confirmOrderUseCase,
        private readonly DeleteOrderUseCase $deleteOrderUseCase
    ) {
    }
    
    /**
     * Create a new order
     */
    public function create(Request $request, Response $response): Response
    {
        $data = json_decode($request->getBody()->getContents(), true);
        
        if (empty($data['user_id'])) {
            return $this->makeMessageResponse($response, 'User ID is required', 400);
        }
        
        try {
            $order = $this->createOrderUseCase->execute((int) $data['user_id']);
            return $this->makeDataResponse($response, $order->toArray(), 201);
        } catch (\RuntimeException $e) {
            return $this->makeMessageResponse($response, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return $this->makeMessageResponse($response, 'Failed to create order: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * Get order by ID
     */
    public function show(Request $request, Response $response, array $args): Response
    {
        $orderId = (int) $args['id'];
        $order = $this->getOrderUseCase->execute($orderId);
        
        if ($order === null) {
            return $this->makeMessageResponse($response, 'Order not found', 404);
        }
        
        return $this->makeDataResponse($response, $order->toArray(), 200);
    }
    
    /**
     * Add product to order
     */
    public function addProduct(Request $request, Response $response, array $args): Response
    {
        $orderId = (int) $args['id'];
        $data = json_decode($request->getBody()->getContents(), true);
        
        if (empty($data['product_id']) || empty($data['quantity'])) {
            return $this->makeMessageResponse($response, 'Product ID and quantity are required', 400);
        }
        
        try {
            $order = $this->addProductToOrderUseCase->execute(
                $orderId,
                (int) $data['product_id'],
                (int) $data['quantity']
            );
            
            return $this->makeDataResponse($response, $order->toArray(), 200);
        } catch (\RuntimeException $e) {
            return $this->makeMessageResponse($response, $e->getMessage(), 404);
        } catch (\DomainException $e) {
            return $this->makeMessageResponse($response, $e->getMessage(), 400);
        } catch (\Exception $e) {
            return $this->makeMessageResponse($response, 'Failed to add product: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * Update order item quantity
     */
    public function updateItem(Request $request, Response $response, array $args): Response
    {
        $orderId = (int) $args['id'];
        $data = json_decode($request->getBody()->getContents(), true);
        
        if (empty($data['product_id']) || !isset($data['quantity'])) {
            return $this->makeMessageResponse($response, 'Product ID and quantity are required', 400);
        }
        
        try {
            $order = $this->updateOrderItemUseCase->execute(
                $orderId,
                (int) $data['product_id'],
                (int) $data['quantity']
            );
            
            return $this->makeDataResponse($response, $order->toArray(), 200);
        } catch (\RuntimeException $e) {
            return $this->makeMessageResponse($response, $e->getMessage(), 404);
        } catch (\Exception $e) {
            return $this->makeMessageResponse($response, 'Failed to update item: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * Confirm and pay for order
     */
    public function confirm(Request $request, Response $response, array $args): Response
    {
        $orderId = (int) $args['id'];
        
        try {
            $order = $this->confirmOrderUseCase->execute($orderId);
            return $this->makeDataResponse($response, $order->toArray(), 200);
        } catch (\RuntimeException $e) {
            return $this->makeMessageResponse($response, $e->getMessage(), 404);
        } catch (\DomainException $e) {
            return $this->makeMessageResponse($response, $e->getMessage(), 400);
        } catch (\Exception $e) {
            return $this->makeMessageResponse($response, 'Failed to confirm order: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * Delete order
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        $orderId = (int) $args['id'];
        
        try {
            $success = $this->deleteOrderUseCase->execute($orderId);
            
            if (!$success) {
                return $this->makeMessageResponse($response, 'Order not found', 404);
            }
            
            return $this->makeMessageResponse($response, 'Order deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->makeMessageResponse($response, 'Failed to delete order: ' . $e->getMessage(), 500);
        }
    }
}

