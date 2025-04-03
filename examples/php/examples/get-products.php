<?php
require_once __DIR__ . '/../helpers.php';

/**
 * Retrieve the list of products in the system and their respective details using the Reseller Public API.
 */

// Load configurations (e.g., API base URL, protocol, etc.)
$config = loadConfig();

// Define the API endpoint for fetching products
$url = "{$config['PROTOCOL']}://{$config['API_URL']}/api/reseller/v1/products";

// Make an API call to fetch the product list
$response = callApi($url, 'GET');

/**
 * Output the API response for debugging or integration purposes.
 *
 * Expected Response:
 * The `products` endpoint returns a JSON response in the following structure:
 *
 * {
 *   "status": "success",
 *   "code": 200,
 *   "data": {
 *     "currency": "USD",
 *     "categories": {
 *       "C1": { "name": "Gaming Cards" },
 *       "C2": { "name": "Gift Cards" },
 *       "C3": { "name": "Subscription Services" }
 *     },
 *     "products": {
 *       "aa12f456-7890-4abc-82fa-127890abcd12": {
 *         "name": "PlayStation Store Gift Card - $50",
 *         "type": "digital",
 *         "cids": ["C1", "C2"],
 *         "price": 45.00,
 *         "fields": [
 *           {
 *             "type": "text",
 *             "name": "Recipient Name",
 *             "min": "3",
 *             "max": "50",
 *             "required": true
 *           },
 *           {
 *             "type": "text",
 *             "name": "Email Address",
 *             "min": "5",
 *             "max": "50",
 *             "required": true
 *           }
 *         ]
 *       },
 *       "bb45g678-9012-4def-82cb-456789abcd34": {
 *         "name": "Xbox Live Gold - 12 Month Membership",
 *         "type": "digital",
 *         "cids": ["C1", "C3"],
 *         "price": 59.99,
 *         "fields": [
 *           {
 *             "type": "text",
 *             "name": "Xbox Gamertag",
 *             "min": "3",
 *             "max": "50",
 *             "required": true
 *           }
 *         ]
 *       },
 *       "cc78h910-1234-4ghi-82dc-789012abcd56": {
 *         "name": "Amazon Gift Card - $100",
 *         "type": "digital",
 *         "cids": ["C2"],
 *         "price": 95.00,
 *         "fields": [
 *           {
 *             "type": "text",
 *             "name": "Recipient Name",
 *             "min": "3",
 *             "max": "50",
 *             "required": true
 *           },
 *           {
 *             "type": "text",
 *             "name": "Message",
 *             "min": "0",
 *             "max": "200",
 *             "required": false
 *           }
 *         ]
 *       }
 *     }
 *   }
 * }
 *
 * Key Fields:
 * - `status` (string): Indicates whether the request was successful (e.g., "success" or "error").
 * - `code` (integer): HTTP-like status code.
 * - `currency` (string): The currency in which product prices are displayed (e.g., "USD").
 * - `categories` (object): Lists available product categories:
 *   - Keys are category IDs (e.g., "C1", "C2").
 *   - `name` (string): Name of the category (e.g., "Gaming Cards").
 * - `products` (object): Lists all available products, where:
 *   - The key in the `products` object is the **product ID**, a unique UUID string (e.g., `"aa12f456-7890-4abc-82fa-127890abcd12"`).
 *   - Each product includes:
 *     - `name` (string): The product name (e.g., "PlayStation Store Gift Card - $50").
 *     - `type` (string): The type of product (e.g., "digital").
 *     - `cids` (array): Category IDs the product belongs to (e.g., ["C1", "C2"]).
 *     - `price` (float): The cost of the product in the specified currency.
 *     - `fields` (array): Input fields required to place an order for this product:
 *       - `type` (string): The input type (e.g., "text").
 *       - `name` (string): The field label (e.g., "Recipient Name").
 *       - Additional Properties:
 *         - `required` (boolean): Whether the field is mandatory.
 *         - `min`/`max` (integer, optional): Minimum or maximum input lengths.
 */

// Output the API response
echo "HTTP Code: " . $response['http_code'] . PHP_EOL;
echo "Response: " . $response['response'] . PHP_EOL;
