<?php
/**
 * Kamran Sports - Configuration File
 * Copy this file to config.php and update with your actual credentials
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'kamran_sports');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Application Configuration
define('APP_NAME', 'Kamran Sports');
define('APP_ENV', 'development'); // development, staging, production
define('APP_URL', 'http://localhost:3000');
define('API_URL', 'http://localhost:8000');

// Security
define('JWT_SECRET', 'CHANGE_THIS_TO_A_LONG_RANDOM_STRING_IN_PRODUCTION');
define('JWT_EXPIRY', 86400); // 24 hours in seconds
define('PASSWORD_PEPPER', 'CHANGE_THIS_ALSO_TO_A_RANDOM_STRING');

// File Upload Settings
define('UPLOAD_PATH', __DIR__ . '/../uploads/');
define('UPLOAD_MAX_SIZE', 5242880); // 5MB in bytes
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp', 'image/gif']);

// Pagination
define('DEFAULT_PAGE_SIZE', 20);
define('MAX_PAGE_SIZE', 100);

// Email Configuration (for future use)
define('SMTP_HOST', 'smtp.example.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'noreply@kamransports.pk');
define('SMTP_PASSWORD', '');
define('SMTP_FROM_EMAIL', 'noreply@kamransports.pk');
define('SMTP_FROM_NAME', 'Kamran Sports');

// Payment Gateway Configuration
define('STRIPE_PUBLIC_KEY', '');
define('STRIPE_SECRET_KEY', '');
define('JAZZCASH_MERCHANT_ID', '');
define('JAZZCASH_PASSWORD', '');
define('JAZZCASH_INTEGRITY_SALT', '');

// Error Reporting
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Timezone
date_default_timezone_set('Asia/Karachi');

// CORS Settings
define('CORS_ALLOWED_ORIGINS', [
    'http://localhost:3000',
    'http://localhost:5173',
    'https://www.kamransports.pk',
    'https://kamransports.pk'
]);
