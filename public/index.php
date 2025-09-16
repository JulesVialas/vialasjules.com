<?php
session_start();
require __DIR__ . '/../src/Services/Language.php';
require __DIR__ . '/../src/Services/Router.php';
require __DIR__ . '/../src/Controllers/HomeController.php';
require __DIR__ . '/../src/Controllers/AboutController.php';
require __DIR__ . '/../src/Controllers/ContactController.php';

use App\Services\Language;
use App\Services\Router;
use App\Controllers\HomeController;
use App\Controllers\AboutController;
use App\Controllers\ContactController;

Language::init();
$router = new Router();
$router->get('/', [new HomeController(), 'get']);
$router->get('/about', [new AboutController(), 'get']);
$router->get('/contact', [new ContactController(), 'get']);
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch('/' . $uri, $method);