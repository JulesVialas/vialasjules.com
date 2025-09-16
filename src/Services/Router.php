<?php

namespace App\Services;

/**
 * Routeur HTTP simple pour l'application.
 * 
 * Permet de définir des routes GET/POST avec des paramètres d'URL
 * et de les dispatcher vers des callbacks ou des contrôleurs.
 * 
 * @package App\Services
 * @author Jules Vialas
 * @version 1.0.0
 */
class Router {

    /**
     * Tableau des routes enregistrées.
     * 
     * @var array<int, array{method:string,pattern:string,callback:callable}>
     */
    private array $routes = [];

    /**
     * Ajoute une route GET.
     * 
     * @param string $pattern Le chemin avec placeholders (ex: /user/{id})
     * @param callable $callback La fonction ou méthode à appeler
     * @return void
     */
    public function get(string $pattern, callable $callback): void {
        $this->add('GET', $pattern, $callback);
    }

    /**
     * Ajoute une route POST.
     * 
     * @param string $pattern Le chemin avec placeholders (ex: /form)
     * @param callable $callback La fonction ou méthode à appeler
     * @return void
     */
    public function post(string $pattern, callable $callback): void {
        $this->add('POST', $pattern, $callback);
    }

    /**
     * Enregistre une route interne.
     * 
     * Convertit les paramètres {nom} en regex pour matcher l'URL.
     * 
     * @param string $method Méthode HTTP (GET|POST)
     * @param string $pattern Le chemin avec placeholders
     * @param callable $callback La fonction ou méthode à exécuter
     * @return void
     */
    private function add(string $method, string $pattern, callable $callback): void {
        $regex = '#^' . preg_replace('#\{(\w+)\}#', '([^/]+)', $pattern) . '$#';
        $this->routes[] = [
            'method' => $method,
            'pattern' => $regex,
            'callback' => $callback,
        ];
    }

    /**
     * Dispatche une requête vers la route correspondante.
     * 
     * Parcourt les routes enregistrées et exécute le callback correspondant
     * à l'URI et la méthode HTTP. Retourne une erreur 404 si aucune route ne correspond.
     * 
     * @param string $uri L'URI demandée (ex: /user/42)
     * @param string $method Méthode HTTP (GET|POST)
     * @return void
     */
    public function dispatch(string $uri, string $method): void {
        foreach ($this->routes as $route) {
            if ($method === $route['method'] && preg_match($route['pattern'], $uri, $matches)) {
                array_shift($matches);
                call_user_func_array($route['callback'], $matches);
                return;
            }
        }
        http_response_code(404);
        echo '404 Not Found';
    }
}