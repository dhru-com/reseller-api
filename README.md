# Reseller Public API Integration

This project demonstrates the integration of a Reseller Public API using PHP. It contains reusable components for API configuration, utility functions for making API calls, and example scripts for various API endpoints.

---

## Table of Contents

- [Project Structure](#project-structure)
- [Setup Instructions](#setup-instructions)
- [Scripts](#scripts)
    - [Retrieve Account Information](#retrieve-account-information)
    - [Get Products](#get-products)
    - [Place New Order](#place-new-order)
    - [Get Order Details](#get-order-details)
- [Postman Documentation](#postman-documentation)
- [Configuration](#configuration)
- [API Helper Functions](#api-helper-functions)
- [Notes](#notes)
- [License](#license)

---

## Project Structure

- `config.php`  
  _Configurations for API URL, protocol, and Bearer token._

- `helpers.php`  
  _Utility functions for making API requests._

- `examples/`  
  _Contains API example scripts:_
    - `get-account-info.php` — Fetch account information.
    - `get-products.php` — Fetch available products.
    - `place-new-order.php` — Place a new order.
    - `get-order-details.php` — Retrieve details of an order.


## Setup Instructions

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd <repository-directory>
   ```

2. Update the `config.php` file with your API details:
    - Replace the placeholders:
        - `API_URL` with the API base URL.
        - `BEARER_TOKEN` with your API token.
    - Example:
      ```php
      return [
          'API_URL' => 'https://api.example.com',
          'PROTOCOL' => 'https',
          'BEARER_TOKEN' => 'your-bearer-token',
      ];
      ```

3. Install necessary PHP extensions if not already installed:
    - Ensure `curl` is enabled in your PHP configuration (`php.ini`).

4. Run the scripts in the appropriate directories after configuring.

---

## Scripts

### Retrieve Account Information

**File**: `account/get-account-info.php`

This script retrieves account details using the `/account` API endpoint.

- **Expected Response**:
  ```json
  {
    "status": "success",
    "message": "Your account details have been retrieved successfully.",
    "code": 200,
    "data": {
      "currency": "EUR",
      "balance": "450.78000",
      "name": "John Doe",
      "email": "johndoe@example.com"
    }
  }
  ```

- **Run the script**:
  ```bash
  php account/get-account-info.php
  ```

### Get Products

**File**: `products/get-products.php`

This script fetches the list of available products and their details using the `/products` API endpoint.

- **Expected Response**:
    - Includes currency, category details, and a list of products with:
        - `name`
        - `type`
        - `price`
        - Any required transaction `fields`.

- **Run the script**:
  ```bash
  php products/get-products.php
  ```

### Place New Order

**File**: `orders/place-new-order.php`

This script places a new order via the `/order` API endpoint.

- **How it works**:
    - Accepts `product_uuid`, order-specific details (`fields`), and optional fields like `feedback_url` and `IMEI`.

- **Expected Response**:
  ```json
  {
    "status": "success",
    "message": "4 Orders submitted",
    "code": 200,
    "data": [
      {
        "order_uuid": "D25040311111228272516",
        "amount": 1,
        "currency_code": "USD",
        "reference_id": "112233"
      }
    ]
  }
  ```

- **Run the script**:
  ```bash
  php orders/place-new-order.php
  ```

### Get Order Details

**File**: `orders/get-order-details.php`

This script retrieves details for a specific order using the `/order` endpoint.

- **Edit `orderUuid`**:
  Replace `E121110144452240` with the actual Order UUID in the script:
  ```php
  $orderUuid = 'YOUR_ORDER_UUID';
  ```

- **Expected Response**:
  ```json
  {
    "status": "success",
    "message": "Order Details",
    "code": 200,
    "data": {
      "quantity": 1,
      "status": "success",
      "date": "2025-04-03 11:11:12",
      "date_completed": "2025-04-03 11:25:35"
    }
  }
  ```

- **Run the script**:
  ```bash
  php orders/get-order-details.php
  ```

---

## Postman Documentation

For a detailed explanation of all the API endpoints, request payloads, and sample responses, refer to the Postman documentation:

[API Documentation on Postman](https://documenter.getpostman.com/view/23443351/2sB2cShPhS)

You can also import this documentation into Postman for testing the endpoints interactively.

---

## Configuration

The `config.php` file contains essential API configurations:

```php
return [
    'API_URL' => 'https://api.example.com',  // Replace with your API base URL
    'PROTOCOL' => 'https',                  // Protocol: http or https
    'BEARER_TOKEN' => 'your-bearer-token',  // Replace with your Bearer token
];
```

### Customize Configurations

Modify this file to connect to the desired API endpoint.

---

## API Helper Functions

All API-related calls are processed using the `callApi` function in the `helpers.php` file.

### Function: `callApi`
Usage:
```php
$response = callApi($url, $method, $headers, $body);
```
Parameters:
- `$url`: Complete API endpoint URL.
- `$method`: HTTP method (GET, POST, PUT, DELETE).
- `$headers`: Additional headers as an array (optional).
- `$body`: Request body (optional, for POST/PUT requests).

Example:
```php
$headers = ['X-Custom-Header: HeaderValue'];
$body = ['key' => 'value'];

$response = callApi('https://api.example.com/v1/endpoint', 'POST', $headers, $body);
```

### Function: `loadConfig`
- Loads the configurations from `config.php`.

---

## Notes

- This project assumes the API returns JSON responses. Modify the processing logic if the API responds differently.
- Error handling is minimal; adapt it to handle more edge cases in production usage.

---

## License

This project is licensed under the MIT License. You are free to modify and distribute the code.
