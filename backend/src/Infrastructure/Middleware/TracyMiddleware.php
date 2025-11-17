<?php declare(strict_types=1);

namespace App\Infrastructure\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Tracy\Debugger;

class TracyMiddleware implements MiddlewareInterface
{
    private array $config;
    
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->initializeTracy();
    }
    
    private function initializeTracy(): void
    {
        if (!$this->config['enabled']) {
            return;
        }
        
        Debugger::enable(
            $this->config['development'] ? Debugger::Development : Debugger::Production,
            $this->config['logDirectory'],
        );

    }

    
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $response = $handler->handle($request);
            return $response;
        } catch (\Throwable $e) {
            // Tracy will handle the exception display
            if ($this->config['enabled']) {
                Debugger::log($e);
            }
            throw $e;
        }
    }

}

