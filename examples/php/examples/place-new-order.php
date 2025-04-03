<?php

require_once __DIR__ . '/../helpers.php';

/**
 * Place a new order using the Reseller Public API and handle the response.
 */

// Load configurations (e.g., API URL, Bearer token, etc.)
$config = loadConfig();

// Define the API endpoint
$url = "{$config['PROTOCOL']}://{$config['API_URL']}/api/reseller/v1/order";

/**
 * Request payload for placing the order.
 *
 * @var array $data
 * - product_uuid: string (Mandatory) - The unique identifier of the product or service to order.
 * - fields: array (Mandatory) - An array containing details for each order of the same product.
 *   - feedback_url: string (Optional for each order) - A URL where order status updates (like success or rejection) will be sent.
 *   - reference_id: string (Mandatory for each order) - A unique identifier for the request/order (used for tracking).
 *   - Quantity: int (Mandatory) - Quantity of the product being ordered.
 *   - Additional fields can vary depending on the product, such as "IMEI", "username", etc.
 *
 * If submitting bulk orders for multiple products, append additional arrays to the `$data` array.
 */
$data = [
    [
        "product_uuid" => "dd44ccc4-9139-11ef-9b79-11111111111", // Unique product/service identifier
        "fields" => [
            [
                "feedback_url" => "https://example.com?action=feedback&order_id=112233",
                "reference_id" => "112233",
                "Quantity" => 1,
                "IMEI" => "11111111111119",
                "username" => "test-user"
            ],
            [
                "feedback_url" => "https://example.com?action=feedback&order_id=112234",
                "reference_id" => "112234",
                "Quantity" => 2,
                "IMEI" => "22222222222229",
                "username" => "example-user"
            ]
        ]
    ],
    [
        "product_uuid" => "ee55ddd4-9139-22ab-9b79-22222222222",
        "fields" => [
            [
                "feedback_url" => "https://example.com?action=feedback&order_id=223344",
                "reference_id" => "223344",
                "Quantity" => 1,
                "IMEI" => "33333333333339",
                "username" => "another-user"
            ]
        ]
    ]
];

// Make the API call to place the order
$response = callApi($url, 'POST', [], $data);

/**
 * Output the API response for debugging or integration purposes.
 * - HTTP Code: Status code returned by the API (e.g., 200, 400, etc.)
 * - Response: The actual API response in JSON format.
 *
 * Expected Response:
 * The API returns a JSON object with the following structure:
 * {
 *   "status": "success",
 *   "message": "4 Orders submitted",
 *   "code": 200,
 *   "data": [
 *     [
 *       {
 *         "order_uuid": "D25040311111228272516",  // Unique ID for Order 1
 *         "amount": 1,                           // Quantity of items processed for this order
 *         "currency_code": "USD",                // Transaction currency
 *         "reference_id": "1204817"              // Reference ID from the request payload
 *       },
 *       {
 *         "order_uuid": "Q25040311111231096887",  // Unique ID for Order 2
 *         "amount": 1,
 *         "currency_code": "USD",
 *         "reference_id": "1204818"
 *       },
 *       ...
 *     ]
 *   ]
 * }
 *
 * Key Fields in the Response:
 * - status: The status of the API call. Possible values: "success", "error".
 * - message: A summary message about the operation performed.
 * - code: The HTTP-like status code for the operation (e.g., 200 for success).
 * - data: An array of arrays, where each element corresponds to a batch of orders.
 *   - order_uuid: Unique identifier for the individual order created by the system.
 *   - amount: Quantity of items processed for the specific order.
 *   - currency_code: Transaction currency in ISO 4217 format (e.g., "USD").
 *   - reference_id: Identifier from the original request for tracking.
 *
 * Errors (if any):
 * If the request fails for certain orders, the response might include:
 * - error_message: Describes the reason for the failure.
 * - reference_id: Links the error to the corresponding request item.
 *
 * Example Error Response:
 * {
 *   "status": "error",
 *   "message": "Some orders failed to process",
 *   "code": 400,
 *   "data": [
 *     {
 *       "reference_id": "1204820",
 *       "message": "Invalid IMEI number"
 *     },
 *     ...
 *   ]
 * }
 */
echo "HTTP Code: " . $response['http_code'] . PHP_EOL;
echo "Response: " . $response['response'] . PHP_EOL;
