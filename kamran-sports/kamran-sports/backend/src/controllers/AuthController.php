<?php

class AuthController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function register($params = []) {
        // TODO: Implement user registration
        http_response_code(501);
        echo json_encode([
            'success' => false,
            'message' => 'Registration endpoint - coming soon'
        ]);
    }

    public function login($params = []) {
        // TODO: Implement login with JWT
        http_response_code(501);
        echo json_encode([
            'success' => false,
            'message' => 'Login endpoint - coming soon'
        ]);
    }

    public function logout($params = []) {
        http_response_code(501);
        echo json_encode([
            'success' => false,
            'message' => 'Logout endpoint - coming soon'
        ]);
    }

    public function forgotPassword($params = []) {
        http_response_code(501);
        echo json_encode([
            'success' => false,
            'message' => 'Forgot password endpoint - coming soon'
        ]);
    }

    public function resetPassword($params = []) {
        http_response_code(501);
        echo json_encode([
            'success' => false,
            'message' => 'Reset password endpoint - coming soon'
        ]);
    }

    public function me($params = []) {
        // TODO: Get current user info from JWT
        http_response_code(501);
        echo json_encode([
            'success' => false,
            'message' => 'Get current user endpoint - coming soon'
        ]);
    }
}
