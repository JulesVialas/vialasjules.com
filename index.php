<?php
require __DIR__ . 'Services/Router.php';
require __DIR__ . 'Controllers/HomeController.php';

use Services\Router;
use Controllers\HomeController;

$router = new Router();

$router->get('/', [new HomeController(), 'get']);

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch('/' . $uri, $method);
