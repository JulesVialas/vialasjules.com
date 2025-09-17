<?php

declare(strict_types=1);

namespace App\Services;

use InvalidArgumentException;

/**
 * HTTP Router
 * Simple router for handling GET/POST routes with URL parameters
 */
class Router
{
    private const SUPPORTED_METHODS = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'];
    
    /** @var array<array{method: string, pattern: string, callback: callable}> */
    private array $routes = [];

    public function get(string $pattern, callable $callback): void
    {
        $this->add('GET', $pattern, $callback);
    }

    public function post(string $pattern, callable $callback): void
    {
        $this->add('POST', $pattern, $callback);
    }

    public function put(string $pattern, callable $callback): void
    {
        $this->add('PUT', $pattern, $callback);
    }

    public function delete(string $pattern, callable $callback): void
    {
        $this->add('DELETE', $pattern, $callback);
    }

    private function add(string $method, string $pattern, callable $callback): void
    {
        if (!in_array($method, self::SUPPORTED_METHODS, true)) {
            throw new InvalidArgumentException("Unsupported HTTP method: {$method}");
        }
        
        $regex = '#^' . preg_replace('#\{(\w+)\}#', '([^/]+)', $pattern) . '$#';
        
        $this->routes[] = [
            'method' => $method,
            'pattern' => $regex,
            'callback' => $callback,
        ];
    }

    public function dispatch(string $uri, string $method): void
    {
        $method = strtoupper($method);
        
        foreach ($this->routes as $route) {
            if ($method === $route['method'] && preg_match($route['pattern'], $uri, $matches)) {
                array_shift($matches); // Remove full match
                
                try {
                    call_user_func_array($route['callback'], $matches);
                } catch (\Throwable $e) {
                    error_log("Route callback error: " . $e->getMessage());
                    $this->sendErrorResponse(500, 'Internal Server Error');
                }
                return;
            }
        }
        
        $this->sendErrorResponse(404, 'Page Not Found');
    }
    
    private function sendErrorResponse(int $code, string $message): void
    {
        http_response_code($code);
        
        // In production, you might want to include a proper error template
        echo "<h1>{$code}</h1><p>{$message}</p>";
    }
}