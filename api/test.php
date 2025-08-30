<?php

// Simple test to verify PHP is working
header('Content-Type: application/json');

echo json_encode([
    'status' => 'success',
    'message' => 'PHP is working on Vercel!',
    'timestamp' => date('Y-m-d H:i:s'),
    'php_version' => PHP_VERSION
]); 