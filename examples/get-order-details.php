<?php
require_once __DIR__ . '/../helpers.php';

/**
 * Retrieve order details from the system using the Reseller Public API.
 */

// Load configurations (such as API base URL, protocol, etc.)
$config = loadConfig();

// Define the API endpoint for fetching order details
$orderUuid = 'E121110144452240'; // Replace with the actual order UUID
$url = "{$config['PROTOCOL']}://{$config['API_URL']}/api/reseller/v1/order?order_uuid={$orderUuid}";

// Make an API call to fetch the order details
$response = callApi($url, 'GET');

/**
 * Output the API response for debugging or integration purposes.
 *
 * Expected Response:
 * The `order` endpoint returns a JSON response in the following structure:
 *
 * {
 *   "status": "success",
 *   "message": "Order Details",
 *   "code": 200,
 *   "data": {
 *     "quantity": 1,
 *     "replay": "REPLAY",
 *     "status": "success",
 *     "date_completed": "2025-04-03 11:25:35",
 *     "date": "2025-04-03 11:11:12"
 *   }
 * }
 *
 * Key Fields:
 * - `status` (string): Indicates whether the request was successful (e.g., "success" or "error").
 * - `message` (string): Contains a brief message for the API response (e.g., "Order Details").
 * - `code` (integer): HTTP-like status code for the response (e.g., 200 = success).
 * - `data` (object): Contains the order details:
 *   - `quantity` (integer): The number of products in the order.
 *   - `replay` (string): The reply or response message related to the order.
 *   - `status` (string): The current status of the order (e.g., "success").
 *   - `date_completed` (string): The date and time the order was completed (in `YYYY-MM-DD HH:mm:ss` format).
 *   - `date` (string): The date and time the order was created (in `YYYY-MM-DD HH:mm:ss` format).
 */

// Output the API response
echo "HTTP Code: " . $response['http_code'] . PHP_EOL;
echo "Response: " . $response['response'] . PHP_EOL;
