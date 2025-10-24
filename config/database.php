<?php
/**
 * Database Configuration for World Recipes
 * PUBLIC WEBSITE - NO LOGIN SYSTEM
 * Configure these settings to match your phpMyAdmin/MySQL setup
 */

// Database configuration
define('DB_HOST', 'localhost');     // Usually localhost for XAMPP/WAMP
define('DB_NAME', 'world_recipes'); // Database name
define('DB_USER', 'root');          // Default phpMyAdmin username
define('DB_PASS', '');              // Default phpMyAdmin password (empty for XAMPP)
define('DB_CHARSET', 'utf8mb4');

// Create secure database connection with prepared statements
function getDBConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => false,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        // Don't show detailed error in production
        error_log("Database connection failed: " . $e->getMessage());
        die("Unable to connect to database. Please try again later.");
    }
}

// Sanitize input for display (XSS prevention)
function sanitizeOutput($input) {
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

// Validate and sanitize country parameter
function validateCountry($country) {
    $allowedCountries = ['Japan', 'India', 'Mexico', 'America', 'Italy'];
    return in_array($country, $allowedCountries) ? $country : null;
}

// Validate recipe ID
function validateRecipeId($id) {
    return filter_var($id, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 999999]
    ]);
}

// Test connection function
function testConnection() {
    try {
        $pdo = getDBConnection();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>