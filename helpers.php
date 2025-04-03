<?php
// Helper functions for making API calls

/**
 * Perform a cURL request.
 *
 * @param string $url The complete API endpoint URL.
 * @param string $method HTTP method: GET, POST, PUT, DELETE, etc.
 * @param array|null $headers Optional additional headers.
 * @param array|null $body Optional request body for POST/PUT requests.
 *
 * @return array Contains 'http_code' and 'response'.
 */
function callApi($url, $method = 'GET', $headers = [], $body = null)
{
    // Initialize cURL
    $ch = curl_init($url);

    // Add common headers like Authorization
    $commonHeaders = [
        "Authorization: Bearer " . loadConfig()['BEARER_TOKEN'],
    ];

    if ($method === 'POST' || $method === 'PUT') {
        $commonHeaders[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    }

    // Merge headers
    $allHeaders = array_merge($commonHeaders, $headers);

    // Set options for cURL
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $allHeaders);

    // Execute the request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return [
        'http_code' => $httpCode,
        'response' => $response,
    ];
}

/**
 * Load configurations from config.php.
 *
 * @return array Config settings as an associative array.
 */
function loadConfig()
{
    return include __DIR__ . '/config.php';
}
