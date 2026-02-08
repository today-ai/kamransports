<?php

class Router {
    private $routes = [];

    public function add($method, $path, $handler) {
        $pattern = '#^' . preg_replace('/\{([a-z]+)\}/', '(?P<$1>[^/]+)', $path) . '$#';
        $this->routes[] = [
            'method' => strtoupper($method),
            'pattern' => $pattern,
            'handler' => $handler
        ];
    }

    public function get($path, $handler) {
        $this->add('GET', $path, $handler);
    }

    public function post($path, $handler) {
        $this->add('POST', $path, $handler);
    }

    public function put($path, $handler) {
        $this->add('PUT', $path, $handler);
    }

    public function delete($path, $handler) {
        $this->add('DELETE', $path, $handler);
    }

    public function dispatch($method, $path) {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $path, $matches)) {
                // Extract named parameters
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                // Call handler
                $handler = $route['handler'];
                if (is_array($handler)) {
                    [$controller, $action] = $handler;
                    $controllerInstance = new $controller();
                    call_user_func_array([$controllerInstance, $action], [$params]);
                } else {
                    call_user_func($handler, $params);
                }
                return;
            }
        }

        // No route found
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Endpoint not found'
        ]);
    }
}
