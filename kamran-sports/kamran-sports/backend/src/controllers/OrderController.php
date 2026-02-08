<?php

class OrderController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function index($params = []) {
        http_response_code(501);
        echo json_encode([
            'success' => false,
            'message' => 'Get orders endpoint - coming soon'
        ]);
    }

    public function show($params) {
        http_response_code(501);
        echo json_encode([
            'success' => false,
            'message' => 'Get order details endpoint - coming soon'
        ]);
    }

    public function store($params = []) {
        http_response_code(501);
        echo json_encode([
            'success' => false,
            'message' => 'Create order endpoint - coming soon'
        ]);
    }

    public function updateStatus($params) {
        http_response_code(501);
        echo json_encode([
            'success' => false,
            'message' => 'Update order status endpoint - coming soon'
        ]);
    }

    public function getCart($params = []) {
        http_response_code(501);
        echo json_encode([
            'success' => false,
            'message' => 'Get cart endpoint - coming soon'
        ]);
    }

    public function addToCart($params = []) {
        http_response_code(501);
        echo json_encode([
            'success' => false,
            'message' => 'Add to cart endpoint - coming soon'
        ]);
    }

    public function updateCart($params = []) {
        http_response_code(501);
        echo json_encode([
            'success' => false,
            'message' => 'Update cart endpoint - coming soon'
        ]);
    }

    public function removeFromCart($params) {
        http_response_code(501);
        echo json_encode([
            'success' => false,
            'message' => 'Remove from cart endpoint - coming soon'
        ]);
    }
}
