<?php

// Load configurations
require_once 'config/database.php';
require_once 'config/jwt.php';

// Autoload classes using Composer (assuming you have Composer installed)
require_once __DIR__ . '/vendor/autoload.php';

// Load necessary core components
require_once 'api/core/Database.php';
require_once 'api/core/Jwt.php';

// Handle CORS (Cross-Origin Resource Sharing) headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle OPTIONS request (pre-flight request)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Handle incoming API requests
try {
    // Perform any other global actions or checks if needed
    
    // Call the appropriate route based on the request
    require_once 'api/routes.php';
} catch (Exception $e) {

    // Handle exceptions and return appropriate response
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Internal Server Error", "error" => $e));
}
