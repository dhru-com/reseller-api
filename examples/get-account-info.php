<?php
require_once __DIR__ . '/../helpers.php';

/**
 * Retrieve account details from the Reseller Public API.
 */

// Load configurations (such as API base URL, protocol, etc.)
$config = loadConfig();

// Define the API endpoint for fetching account details
$url = "{$config['PROTOCOL']}://{$config['API_URL']}/api/reseller/v1/account";

// Make an API call to fetch the account information
$response = callApi($url, 'GET');

/**
 * Output the API response for debugging or integration purposes.
 *
 * Expected Response:
 * The `account` endpoint returns a JSON response with the following structure:
 *
 * {
 *   "status": "success",
 *   "message": "Your account details have been retrieved successfully.",
 *   "code": 200,
 *   "data": {
 *     "currency": "EUR",
 *     "balance": "450.78000",
 *     "name": "John Doe",
 *     "email": "johndoe@example.com"
 *   }
 * }
 *
 * Key Fields:
 * - `status` (string): Indicates whether the request was successful (e.g., "success" or "error").
 * - `message` (string): A message describing the response (e.g., "Your account details have been retrieved successfully.").
 * - `code` (integer): HTTP-like status code (e.g., 200 for success).
 * - `data` (object): The account details:
 *   - `currency` (string): The currency associated with the account (e.g., "EUR").
 *   - `balance` (string): The current account balance represented as a string (to preserve precision, e.g., "450.78000").
 *   - `name` (string): The name of the account owner (e.g., "John Doe").
 *   - `email` (string): The account owner's email address (e.g., "johndoe@example.com").
 */

// Output the API response
echo "HTTP Code: " . $response['http_code'] . PHP_EOL;
echo "Response: " . $response['response'] . PHP_EOL;
