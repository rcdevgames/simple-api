<?php

// Import Classes
require_once "library/response.php";
require_once "library/input.php";

// Load controllers dynamically
$controllerPath = __DIR__ . '/controllers';
$controllers = scandir($controllerPath);

foreach ($controllers as $controllerFile) {
    if ($controllerFile !== '.' && $controllerFile !== '..' && is_file($controllerPath . '/' . $controllerFile)) {
        require_once $controllerPath . '/' . $controllerFile;
    }
}

// Define routes based on controller methods
foreach (get_declared_classes() as $className) {
    if (strpos($className, 'Controller') !== false) {
        $controllerName = str_replace('Controller', '', $className);
        $methods = get_class_methods($className);

        foreach ($methods as $method) {
            if (strpos($method, '_') !== false) {
                list($prefix, $route) = explode('_', $method, 2);

                if ($prefix === 'get') {
                    $methodType = 'GET';
                } elseif ($prefix === 'post') {
                    $methodType = 'POST';
                } elseif ($prefix === 'put') {
                    $methodType = 'PUT';
                } elseif ($prefix === 'delete') {
                    $methodType = 'DELETE';
                } else {
                    continue;
                }

                $route = strtolower($route);
                $endpoint = '/' . $route;

                $controllerInstance = new $className();
                $callback = array($controllerInstance, $method);

                // Handle route based on method type
                if ($_SERVER['REQUEST_METHOD'] === $methodType && strpos($_SERVER['REQUEST_URI'], $endpoint) === 0) {
                    // Parse parameters from URL
                    $urlParts = parse_url($_SERVER['REQUEST_URI']);
                    $query = isset($urlParts['query']) ? $urlParts['query'] : '';
                    parse_str($query, $parameters);
                    
                    // Call controller method with parameters
                    $callback($parameters);
                    exit(); // Stop further processing
                }
            }
        }
    }
}

// Handle not found routes
$data = [
    "success" => false,
    "message" => "Route not found"
];
return Response::JSON($data, 404);
