<?php
/**
 * Routeur simple pour IntraSphere PHP
 */

class Router {
    private $routes = [];
    private $params = [];

    public function get($pattern, $handler) {
        $this->addRoute('GET', $pattern, $handler);
    }

    public function post($pattern, $handler) {
        $this->addRoute('POST', $pattern, $handler);
    }

    public function put($pattern, $handler) {
        $this->addRoute('PUT', $pattern, $handler);
    }

    public function patch($pattern, $handler) {
        $this->addRoute('PATCH', $pattern, $handler);
    }

    public function delete($pattern, $handler) {
        $this->addRoute('DELETE', $pattern, $handler);
    }

    private function addRoute($method, $pattern, $handler) {
        $this->routes[] = [
            'method'  => $method,
            'pattern' => $pattern,
            'handler' => $handler
        ];
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Supprimer /public du début de l'URI si présent
        $uri = preg_replace('#^/public#', '', $uri);

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchRoute($route['pattern'], $uri)) {
                return $this->callHandler($route['handler']);
            }
        }

        // Route non trouvée
        Response::notFound('Route not found');
    }

    private function matchRoute($pattern, $uri) {
        // Convertir le pattern en regex
        $regex = preg_replace('/\{([^}]+)\}/', '([^/]+)', $pattern);
        $regex = '#^' . $regex . '$#';

        if (preg_match($regex, $uri, $matches)) {
            // Extraire les paramètres
            array_shift($matches);
            preg_match_all('/\{([^}]+)\}/', $pattern, $paramNames);
            $paramNames = $paramNames[1];
            $this->params = array_combine($paramNames, $matches);
            return true;
        }

        return false;
    }

    private function callHandler($handler) {
        if (is_callable($handler)) {
            return $handler();
        }

        if (is_string($handler) && strpos($handler, '@') !== false) {
            list($controllerName, $method) = explode('@', $handler);

            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if (method_exists($controller, $method)) {
                    $input = $this->getInput();
                    return $controller->$method($this->params, $input);
                }
            }
        }

        Response::serverError('Handler not found');
    }

    private function getInput() {
        $input = [];

        // GET parameters
        $input = array_merge($input, $_GET);

        // POST parameters
        $input = array_merge($input, $_POST);

        // JSON body
        $json = json_decode(file_get_contents('php://input'), true);
        if ($json) {
            $input = array_merge($input, $json);
        }

        return $input;
    }
}