<?php
namespace services;

/**
 * Class Router
 *
 * Un routeur HTTP simple maison permettant de définir des routes GET/POST
 * avec des paramètres d'URL (ex: /user/{id}) et de les dispatcher
 * vers des callbacks ou des contrôleurs.
 */
class Router {

    /**
     * Tableau des routes enregistrées.
     *
     * Chaque entrée est un tableau associatif :
     * [
     *   'method'   => 'GET'|'POST',
     *   'pattern'  => '#^/user/([^/]+)$#',
     *   'callback' => callable
     * ]
     *
     * @var array<int, array{method:string,pattern:string,callback:callable}>
     */
    private array $routes = [];

    /**
     * Ajoute une route GET.
     *
     * @param string   $pattern  Le chemin (ex: /user/{id})
     * @param callable $callback La fonction ou méthode à appeler
     *
     * @return void
     */
    public function get(string $pattern, callable $callback): void {
        $this->add('GET', $pattern, $callback);
    }

    /**
     * Ajoute une route POST.
     *
     * @param string   $pattern  Le chemin (ex: /form)
     * @param callable $callback La fonction ou méthode à appeler
     *
     * @return void
     */
    public function post(string $pattern, callable $callback): void {
        $this->add('POST', $pattern, $callback);
    }

    /**
     * Enregistre une route interne (GET ou POST).
     *
     * Convertit les paramètres {nom} en regex pour matcher l'URL.
     *
     * @param string   $method   Méthode HTTP (GET|POST)
     * @param string   $pattern  Le chemin avec placeholders
     * @param callable $callback La fonction ou méthode à exécuter
     *
     * @return void
     */
    private function add(string $method, string $pattern, callable $callback): void {
        // Convertir /user/{id} en regex #^/user/([^/]+)$#
        $regex = '#^' . preg_replace('#\{(\w+)\}#', '([^/]+)', $pattern) . '$#';
        $this->routes[] = [
            'method' => $method,
            'pattern' => $regex,
            'callback' => $callback,
        ];
    }

    /**
     * Parcourt les routes enregistrées et exécute le callback correspondant
     * à l'URL et la méthode HTTP courante.
     *
     * @param string $uri    L'URI demandée (ex: /user/42)
     * @param string $method Méthode HTTP (GET|POST)
     *
     * @return void
     */
    public function dispatch(string $uri, string $method): void {
        foreach ($this->routes as $route) {
            if ($method === $route['method'] && preg_match($route['pattern'], $uri, $matches)) {
                array_shift($matches); // enlève la correspondance complète
                call_user_func_array($route['callback'], $matches);
                return;
            }
        }

        // Si aucune route ne correspond :
        http_response_code(404);
        echo '404 Not Found';
    }
}