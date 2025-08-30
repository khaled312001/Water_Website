<?php

// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Check if vendor directory exists
    if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
        throw new Exception('Vendor directory not found. Please run composer install');
    }

    // Load Composer's autoloader
    require_once __DIR__ . '/../vendor/autoload.php';

    // Check if bootstrap/app.php exists
    if (!file_exists(__DIR__ . '/../bootstrap/app.php')) {
        throw new Exception('Laravel bootstrap file not found');
    }

    // Bootstrap Laravel
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    // Create kernel
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    // Capture request
    $request = Illuminate\Http\Request::capture();

    // Handle request
    $response = $kernel->handle($request);

    // Send response
    $response->send();

    // Terminate
    $kernel->terminate($request, $response);

} catch (Exception $e) {
    // Return error response
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Laravel bootstrap failed',
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
} 