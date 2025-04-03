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

---

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
  The endpoint returns a JSON response in the following format:
  ```json
  {
    "status": "success",
    "code": 200,
    "data": {
      "currency": "USD",
      "categories": {
        "C1": { "name": "Gaming Cards" },
        "C2": { "name": "Gift Cards" },
        "C3": { "name": "Subscription Services" }
      },
      "products": {
        "aa12f456-7890-4abc-82fa-127890abcd12": {
          "name": "PlayStation Store Gift Card - $50",
          "type": "digital",
          "cids": ["C1", "C2"],
          "price": 45.00,
          "fields": [
            {
              "type": "text",
              "name": "Recipient Name",
              "min": 3,
              "max": 50,
              "required": true
            },
            {
              "type": "text",
              "name": "Email Address",
              "min": 5,
              "max": 50,
              "required": true
            }
          ]
        }
        // Additional products...
      }
    }
  }
  ```

- **Key Fields**:
    - `status`: Indicates success or failure.
    - `categories`: Product categories with their IDs.
    - `products`: List of available products, each containing:
        - `name`: Name of the product.
        - `price`: The cost of the product.
        - `fields`: Additional inputs required for an order.

- **Run the Script**:
  ```bash
  php products/get-products.php
  ```

### Place New Order

**File**: `orders/place-new-order.php`

This script places a new order via the `/order` API endpoint.

- **Request Example**:  
  The request payload should include the product details and additional fields, as shown below:
  ```json
  [
    {
      "product_uuid": "dd44ccc4-9139-11ef-9b79-11111111111",
      "fields": [
        {
          "feedback_url": "https://example.com?action=feedback&order_id=112233",
          "reference_id": "112233",
          "Quantity": 1,
          "IMEI": "11111111111119",
          "username": "test-user"
        },
        {
          "feedback_url": "https://example.com?action=feedback&order_id=112234",
          "reference_id": "112234",
          "Quantity": 2,
          "IMEI": "22222222222229",
          "username": "example-user"
        }
      ]
    },
    {
      "product_uuid": "ee55ddd4-9139-22ab-9b79-22222222222",
      "fields": [
        {
          "feedback_url": "https://example.com?action=feedback&order_id=223344",
          "reference_id": "223344",
          "Quantity": 1,
          "IMEI": "33333333333339",
          "username": "another-user"
        }
      ]
    }
  ]
  ```

- **Expected Response**:
  ```json
  {
    "status": "success",
    "message": "4 Orders submitted",
    "code": 200,
    "data": [
      [
        {
          "order_uuid": "D25040311111228272516",
          "amount": 1,
          "currency_code": "USD",
          "reference_id": "112233"
        },
        {
          "order_uuid": "Q25040311111231096887",
          "amount": 2,
          "currency_code": "USD",
          "reference_id": "112234"
        }
      ]
    ]
  }
  ```

- **Key Fields**:
    - `order_uuid`: Unique order identifier.
    - `amount`: Quantity of items processed.
    - `reference_id`: Request identifier for tracking.

- **Run the Script**:
  ```bash
  php orders/place-new-order.php
  ```

### Get Order Details

**File**: `orders/get-order-details.php`

This script retrieves details for a specific order using the `/order` API endpoint.

- **Edit `orderUuid`**:
  Replace `YOUR_ORDER_UUID` with the actual Order UUID in the script:
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
      "date": "2025-04-03 11:42:00"
    }
  }
  ```

- **Run the Script**:
  ```bash
  php orders/get-order-details.php
  ```

---

## Postman Documentation

Refer to the Postman documentation for further details on the API.

---

## Notes

- Ensure you have a valid Bearer Token configured in `config.php`.

---

## License

This project is licensed under the MIT License.
