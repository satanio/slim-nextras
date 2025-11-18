<?php declare(strict_types=1);

namespace App\Interface\Http\Controllers;

use App\Application\UseCases\GetRandomProductUseCase;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProductController extends BaseController
{
    
    public function __construct(
        private readonly GetRandomProductUseCase $getRandomProductUseCase
    ) {
    }
    
    /**
     * Get a random product
     */
    public function random(Request $request, Response $response): Response
    {
        $product = $this->getRandomProductUseCase->execute();
        
        if ($product === null) {
            return $this->makeMessageResponse($response, 'No products available', 404);
        }
        
        return $this->makeDataResponse($response, $product->toArray(), 200);
    }
}

