<?php

return [
    'paths' => ['*'],  // Apply to all routes
    'allowed_methods' => ['*'],         // Allow all methods
    'allowed_origins' => ['http://localhost:5173'],  // Allow requests from your frontend
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],         // Allow all headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
