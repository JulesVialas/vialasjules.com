<?php

declare(strict_types=1);


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Portfolio Website Entry Point
 * Main application bootstrap with routing and language initialization
 */

session_start();

// Custom autoloader
require_once __DIR__ . '/../src/Autoloader.php';

$autoloader = new Autoloader();

$autoloader->addNamespace('App', __DIR__ . '/../src');
$autoloader->register();

use App\Services\Language;
use App\Services\Router;
use App\Controllers\HomeController;
use App\Controllers\ContactController;

try {
    // Initialize language service
    Language::init();
    
    // Setup routing
    $router = new Router();
    $router->get('/', [new HomeController(), 'index']);
    $router->post('/contact', [new ContactController(), 'submitForm']);
    
    // Parse request
    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '', '/');
    $method = $_SERVER['REQUEST_METHOD'];
    
    // Dispatch request
    $router->dispatch('/' . $uri, $method);
} catch (Throwable $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo 'Internal Server Error';
}