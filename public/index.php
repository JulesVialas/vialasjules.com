<?php
session_start();
require __DIR__ . '/../src/Services/Language.php';
require __DIR__ . '/../src/Services/Router.php';
require __DIR__ . '/../src/Controllers/HomeController.php';

use App\Services\Language;
use App\Services\Router;
use App\Controllers\HomeController;

Language::init();
$router = new Router();
$router->get('/', [new HomeController(), 'get']);
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch('/' . $uri, $method);