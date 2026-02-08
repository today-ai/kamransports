<?php
/**
 * API Routes Definition
 */

require_once __DIR__ . '/../controllers/ProductController.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/OrderController.php';

function registerRoutes(Router $router) {
    // Health check
    $router->get('/health', function() {
        echo json_encode([
            'success' => true,
            'message' => 'Kamran Sports API is running',
            'version' => '1.0.0',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    });

    // Authentication routes
    $router->post('/auth/register', ['AuthController', 'register']);
    $router->post('/auth/login', ['AuthController', 'login']);
    $router->post('/auth/logout', ['AuthController', 'logout']);
    $router->post('/auth/forgot-password', ['AuthController', 'forgotPassword']);
    $router->post('/auth/reset-password', ['AuthController', 'resetPassword']);
    $router->get('/auth/me', ['AuthController', 'me']);

    // Product routes
    $router->get('/products', ['ProductController', 'index']);
    $router->get('/products/{slug}', ['ProductController', 'show']);
    $router->post('/products', ['ProductController', 'store']);
    $router->put('/products/{id}', ['ProductController', 'update']);
    $router->delete('/products/{id}', ['ProductController', 'destroy']);
    
    // Category routes
    $router->get('/categories', ['ProductController', 'categories']);
    $router->get('/categories/{slug}', ['ProductController', 'categoryProducts']);

    // Order routes
    $router->get('/orders', ['OrderController', 'index']);
    $router->get('/orders/{orderNumber}', ['OrderController', 'show']);
    $router->post('/orders', ['OrderController', 'store']);
    $router->put('/orders/{id}/status', ['OrderController', 'updateStatus']);

    // Cart routes (session-based for guests, user-based for authenticated)
    $router->get('/cart', ['OrderController', 'getCart']);
    $router->post('/cart/add', ['OrderController', 'addToCart']);
    $router->put('/cart/update', ['OrderController', 'updateCart']);
    $router->delete('/cart/remove/{id}', ['OrderController', 'removeFromCart']);

    // More routes will be added as development progresses
}
