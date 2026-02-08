<?php
/**
 * Kamran Sports API - Main Entry Point
 */

// Load configuration
require_once __DIR__ . '/../config.php';

// Set headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: ' . (in_array($_SERVER['HTTP_ORIGIN'] ?? '', CORS_ALLOWED_ORIGINS) ? $_SERVER['HTTP_ORIGIN'] : '*'));
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Autoloader
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Database connection
require_once __DIR__ . '/../src/utils/Database.php';

// Router
require_once __DIR__ . '/../src/utils/Router.php';
require_once __DIR__ . '/../src/routes/api.php';

try {
    // Get request method and path
    $method = $_SERVER['REQUEST_METHOD'];
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    
    // Remove /api prefix if exists
    $path = preg_replace('#^/api#', '', $path);
    
    // Route the request
    $router = new Router();
    registerRoutes($router);
    $router->dispatch($method, $path);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => APP_ENV === 'development' ? $e->getMessage() : 'Internal server error',
        'trace' => APP_ENV === 'development' ? $e->getTrace() : null
    ]);
}
