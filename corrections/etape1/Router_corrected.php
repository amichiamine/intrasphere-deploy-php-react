<?php
/**
 * Router IntraSphere - Version Corrigée
 * Basé sur 2Router.php qui fonctionne
 */

class Router {
    private $routes = [];

    public function get($path, $handler) {
        $this->routes['GET'][$path] = $handler;
    }

    public function post($path, $handler) {
        $this->routes['POST'][$path] = $handler;
    }

    public function put($path, $handler) {
        $this->routes['PUT'][$path] = $handler;
    }

    public function patch($path, $handler) {
        $this->routes['PATCH'][$path] = $handler;
    }

    public function delete($path, $handler) {
        $this->routes['DELETE'][$path] = $handler;
    }

    public function dispatch($method, $uri) {
        // Nettoyer l'URI - SANS ECHO DEBUG
        $uri = str_replace('/intrasphere', '', $uri);
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = rtrim($uri, '/') ?: '/';

        // Chercher la route exacte
        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];

            if (is_callable($handler)) {
                $handler();
            } else {
                list($controller, $action) = explode('@', $handler);

                // Autoloader simple pour les contrôleurs
                $controllerFile = __DIR__ . '/../Controllers/' . $controller . '.php';
                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    $instance = new $controller();
                    $instance->$action();
                } else {
                    Response::error("Controller $controller not found", 500);
                }
            }
            return;
        }

        // Route non trouvée
        Response::error('Route not found', 404);
    }
}
?>