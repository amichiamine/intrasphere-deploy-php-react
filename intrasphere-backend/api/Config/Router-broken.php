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

    public function dispatch($method, $uri) {
            // DEBUG : voir ce qui arrive
    echo "DEBUG - Method: $method\n";
    echo "DEBUG - URI reçue: $uri\n";
    // Nettoyer l'URI : supprimer /intrasphere si présent
    $uri = str_replace('/intrasphere', '', $uri);
    
    // Supprimer les paramètres GET
    $uri = parse_url($uri, PHP_URL_PATH);
    
    // Nettoyer les slashes multiples
    $uri = rtrim($uri, '/');
    if (empty($uri)) {
        $uri = '/';
    }
    
    // Debug : voir quelle URI est reçue
    error_log("Router dispatch: method=$method, uri=$uri");
    
    // Chercher la route correspondante
    $routes = $this->routes[$method] ?? [];
    
    foreach ($routes as $route => $handler) {
        // Pattern pour les paramètres {id}
        $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route);
        $pattern = str_replace('/', '\/', $pattern);
        $pattern = '/^' . $pattern . '$/';
        
        if (preg_match($pattern, $uri, $matches)) {
            array_shift($matches); // Supprimer le match complet
            
            if (is_callable($handler)) {
                // Fonction anonyme
                call_user_func_array($handler, $matches);
            } else {
                // Contrôleur@méthode
                list($controller, $action) = explode('@', $handler);
                $controllerFile = __DIR__ . '/../Controllers/' . $controller . '.php';
                
                if (file_exists($controllerFile)) {
                    require_once $controllerFile;
                    $instance = new $controller();
                    call_user_func_array([$instance, $action], $matches);
                } else {
                    Response::error("Controller $controller not found", 500);
                    return;
                }
            }
            return;
        }
    }
    
    // Aucune route trouvée
    Response::error('Route not found', 404);
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